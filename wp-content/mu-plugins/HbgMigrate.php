<?php

/**
 * Plugin Name:       Hbg Widget Migrater
 * Plugin URI:
 * Description:
 * Version:           1.0.0
 * Author:            Kristoffer Svanmark
 * Author URI:
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       hbg-migrate
 * Domain Path:       /languages
 */

add_action('init', function () {

    if (function_exists('kses_remove_filters')) {
        kses_remove_filters();
    }

    // Create sites
    if (isset($_GET['create-sites']) && $_GET['create-sites'] === 'true') {
        set_time_limit(9999999);

        global $wpdbFrom;
        $wpdbFrom = new \wpdb(DB_USER, DB_PASSWORD, 'hbg_old', DB_HOST);
        $placeholders = array();

        // Get sites in old db
        $sites = $wpdbFrom->get_results("SELECT * FROM wp_blogs");

        $i = 0;
        foreach ($sites as $site) {
            $i++;
            $site->blog_id = (int)$site->blog_id;

            // Skip main site
            if ($site->blog_id == 1) {
                continue;
            }

            // If not correct blog_id create a false placeholder blog to get correct blog_id
            while ($i < $site->blog_id) {
                $placeholder = wpmu_create_blog('helsingborg.se', uniqid(), 'Placeholder blog', 1);
                $placeholders[] = $placeholder;
                echo '<span style="color:#ff0000">Created placeholder: ' . $placeholder . ')</span><br>';
                $i++;
            }

            // Get blogname
            $blogname = $wpdbFrom->get_var("SELECT option_value FROM wp_" . $site->blog_id . "_options WHERE option_name = 'blogname'");

            // Create blog
            wpmu_create_blog(str_replace('/', '', $site->path) . '.helsingborg.se', '/', $blogname, 1);
            echo 'Created blog: ' . $blogname . ' (' . str_replace('/', '', $site->path) . ')<br>';
        }

        // Remove placeholder blogs
        foreach ($placeholders as $placeholder) {
            wpmu_delete_blog($placeholder, true);
            echo '<span style="color:#ff0000">Removed placeholder: ' . $placeholder . ')</span><br>';
        }

        echo '<strong>DONE</strong>';

        exit;
    }

    // Migration process
    if (isset($_GET['migrate']) && $_GET['migrate'] === 'yes-please') {
        set_time_limit(9999999);

        global $wpdbFrom;
        $wpdbFrom = new \wpdb(DB_USER, DB_PASSWORD, 'hbg_old', DB_HOST);

        // Include all migration scripts from the hbg-migrate folder
        foreach (glob(__DIR__ . '/hbg-migrate/*.php') as $migrate) {
            require_once $migrate;
        }

        new \HbgMigrate\MigrationEngine();

        exit;
    }

    // Check data strucutre for widget of type
    if (isset($_GET['view_widget_structure'])) {
        set_time_limit(9999999);

        global $wpdbFrom;
        $wpdbFrom = new \wpdb(DB_USER, DB_PASSWORD, 'hbg_old', DB_HOST);

        require __DIR__ . '/hbg-migrate/MigrationEngine.php';
        $engine = new \HbgMigrate\MigrationEngine(false);
        wp_send_json($engine->getWidgetStructure($_GET['view_widget_structure']));
        exit;
    }

    // Check data strucutre for widget of type
    if (isset($_GET['view_widget_types'])) {
        set_time_limit(9999999);

        global $wpdbFrom;
        $wpdbFrom = new \wpdb(DB_USER, DB_PASSWORD, 'hbg_old', DB_HOST);

        require __DIR__ . '/hbg-migrate/MigrationEngine.php';
        $engine = new \HbgMigrate\MigrationEngine(false);

        $types = array();

        if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
            $types = $engine->getWidgetTypes($_GET['post_id']);
        } else {
            $types = $engine->getWidgetTypes();
        }

        wp_send_json($types);
        exit;
    }

    // Migrate color schemes
    if (isset($_GET['migrate-colors']) && $_GET['migrate-colors'] == 'true') {
        set_time_limit(9999999);

        // helsingborg_color_theme
        // helsingborg_color_code
        global $wpdbFrom, $wpdb;
        $wpdbFrom = new \wpdb(DB_USER, DB_PASSWORD, 'hbg_old', DB_HOST);

        $table = 'wp_options';
        if (get_current_blog_id() > 1) {
            $table = 'wp_' . get_current_blog_id() . '_options';
        }

        $theme = $wpdbFrom->get_var("SELECT option_value FROM $table WHERE option_name = 'helsingborg_color_theme'");
        $code = $wpdbFrom->get_var("SELECT option_value FROM $table WHERE option_name = 'helsingborg_color_code'");

        // Set color theme
        update_field('color_scheme', $theme, 'option');

        // Set primary theme color
        update_field('school-primary-color', $code, 'option');

        exit;
    }

    // Migrate logotype
    if (isset($_GET['migrate-logotype']) && $_GET['migrate-logotype'] == 'true') {
        set_time_limit(9999999);

        global $wpdbFrom, $wpdb;
        $wpdbFrom = new \wpdb(DB_USER, DB_PASSWORD, 'hbg_old', DB_HOST);

        $table = 'wp_options';
        if (get_current_blog_id() > 1) {
            $table = 'wp_' . get_current_blog_id() . '_options';
        }

        $logotypeUrl = $wpdbFrom->get_var("SELECT option_value FROM $table WHERE option_name = 'helsingborg_header_image_imageurl'");

        if ($logotypeUrl && substr($logotypeUrl, -4, 4) === '.svg') {
            // Save logotype
            $svg = file_get_contents($logotypeUrl);
            $uploaded = hbg_migrate_upload_image(basename($logotypeUrl), $svg);

            update_field('logotype', $uploaded, 'option');
            update_field('logotype_negative', $uploaded, 'option');

            echo "Logos migrated";
            exit;
        }

        echo "No logos to migrate.";
        exit;
    }

    // Theme options
    if (isset($_GET['migrate-theme-options']) && $_GET['migrate-theme-options'] == 'true') {
        if (is_multisite()) {

            if (get_current_blog_id() > 1) {
                \WP_Theme::network_enable_theme('municipio-school');
            } else {
                \WP_Theme::network_enable_theme('helsingborg');
            }

        }

        if (get_current_blog_id() > 1) {
            switch_theme('municipio-school');
        } else {
            switch_theme('helsingborg');
        }

        global $wpdbFrom;
        $wpdbFrom = new \wpdb(DB_USER, DB_PASSWORD, 'hbg_old', DB_HOST);

        // Front page
        $table = "wp_options";
        if (get_current_blog_id() > 1) {
            $table = "wp_" . get_current_blog_id() . "_options";
        }

        $oldFront = $wpdbFrom->get_var("SELECT option_value FROM $table WHERE option_name = 'page_on_front'");
        if (strlen($oldFront)) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $oldFront);
        }

        // Navigation
        update_field('nav_primary_enable', true, 'option');
        update_field('nav_primary_type', 'wp', 'option');
        update_field('nav_primary_align', 'justify', 'option');

        update_field('cookie_consent_message', 'På helsingborg.se använder vi cookies (kakor) för att webbplatsen ska fungera på ett bra sätt för dig. Genom att klicka vidare godkänner du att vi använder cookies.', 'option');
        update_field('cookie_consent_button', 'Jag godkänner', 'option');

        update_field('footer_logotype', 'negative', 'option');

        update_field('search_display', array('mainmenu', 'header_sub', 'hero'), 'option');
        update_field('search_label_text', 'Sök', 'option');
        update_field('search_placeholder_text', 'Vad letar du efter?', 'option');
        update_field('search_button_text', 'Sök', 'option');

        update_field('404_display', array('home', 'search', 'back'), 'option');
        update_field('404_home_link_text', 'Gå till startsidan', 'option');
        update_field('404_back_button_text', 'Tillbaka till föregående sida', 'option');
        update_field('404_search_link_text', 'Sök efter "%s"', 'option');
    }

    // School options
    if (isset($_GET['migrate-school-options']) && $_GET['migrate-school-options'] == 'true') {
        if (is_multisite()) {
            \WP_Theme::network_enable_theme('municipio-school');
        }

        switch_theme('municipio-school');

        //Site url
        update_option('siteurl', get_option('home') . '/wp/');

        //Header
        update_field('header_layout', 'jumbo', 'option');
        update_field('header_logotype', 'negative', 'option');

        //Menu
        update_field('nav_primary_enable', '1', 'option');
        update_field('nav_primary_type', 'wp', 'option');
        update_field('nav_primary_align', 'right', 'option');

        update_field('nav_sub_enable', '1', 'option');
        update_field('nav_sub_type', 'auto', 'option');
        update_field('nav_sub_render', 'active', 'option');

        update_field('nav_mobile_enable', '1', 'option');

        exit;

    }

    // Event settings
    if (isset($_GET['migrate-event-integration']) && $_GET['migrate-event-integration'] == 'true') {
        update_field('event_api_url', 'https://api.helsingborg.se/event/json/wp/v2', 'option');
        update_field('days_ahead', 60, 'option');
        update_field('event_daily_import', true, 'option');
        update_field('event_post_status', 'publish', 'option');
        update_field('event_geographic_distance', 30, 'option');
        update_field('event_import_geographic', array(
            'address' => 'Helsingborg',
            'lat' => '56.0464674',
            'lng' => '12.694512099999997'
        ), 'option');
    }

    // Modularity settings
    if (isset($_GET['migrate-modularity-options']) && $_GET['migrate-modularity-options'] == 'true') {
        $modularityOptions = array(
            'show-modules-in-menu' => 'on',
            'enabled-post-types' => array(
                'post',
                'page',
            ),
            'enabled-areas' => array(
                'index' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'front-page' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'single' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'single-listing' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'archive' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'archive-listing' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'page' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'author' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'search' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
                'full-width.blade.php' => array(
                    'slider-area',
                    'right-sidebar',
                    'content-area',
                    'content-area-top',
                    'content-area-bottom',
                    'footer-area',
                    'left-sidebar',
                    'left-sidebar-bottom',
                ),
            ),
            'enabled-modules' => array(
                'mod-contacts',
                'mod-fileslist',
                'mod-gallery',
                'mod-iframe',
                'mod-image',
                'mod-index',
                'mod-inlaylist',
                'mod-notice',
                'mod-inheritpost',
                'mod-posts',
                'mod-script',
                'mod-slider',
                'mod-social',
                'mod-table',
                'mod-text',
                'mod-video',
                'mod-wpwidget',
            ),
        );

        update_option('modularity-options', $modularityOptions);
        echo "Updated Modularity options";
        exit;
    }
}, 9999);

function hbg_migrate_upload_image($filename, $data) {
    $uploadDir = wp_upload_dir();

    // Save file to server
    $save = fopen($uploadDir['path'] . $filename, 'w');
    fwrite($save, $data);
    fclose($save);

    // Detect filetype
    $filetype = wp_check_filetype($filename, null);

    // Insert the file to media library
    $attachmentId = wp_insert_attachment(array(
        'guid' => $uploadDir['path'] . $filename,
        'post_mime_type' => $filetype['type'],
        'post_title' => $filename,
        'post_content' => '',
        'post_status' => 'inherit'
    ), $uploadDir['path'] . $filename);

    // Generate attachment meta
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attachData = wp_generate_attachment_metadata($attachmentId, $uploadDir['path'] . $filename);
    wp_update_attachment_metadata($attachmentId, $attachData);

    return $attachmentId;
}
