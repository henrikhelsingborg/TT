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
        wp_send_json($engine->getWidgetTypes());
        exit;
    }

    // Migrate color schemes
    if (isset($_GET['migrate-colors']) && $_GET['migrate-colors'] == 'true') {
        set_time_limit(9999999);

        // helsingborg_color_theme
        // helsingborg_color_code
        add_action('init', function () {
            $theme = get_option('helsingborg_color_theme');
            $code = get_option('helsingborg_color_code');

            // Set color theme
            update_field('field_56a0a7e36365b', $theme, 'option');

            // Set primary theme color
            update_field('field_' . sha1('school-colorscheme-' . $theme), $code, 'option');
        });
    }
});
