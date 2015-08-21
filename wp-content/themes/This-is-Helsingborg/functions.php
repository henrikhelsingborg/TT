<?php

    define('HELSINGBORG_PATH', get_template_directory());
    define('HELSINGBORG_URL', get_template_directory_uri());

    require_once HELSINGBORG_PATH . '/lib/Vendor/Psr4ClassLoader.php';
    require_once HELSINGBORG_PATH . '/lib/Public.php';

    $loader = new Helsingborg\Vendor\Psr4ClassLoader();
    $loader->addPrefix('Helsingborg', HELSINGBORG_PATH);
    $loader->addPrefix('Helsingborg', HELSINGBORG_PATH . '/lib/');
    $loader->register();

    new Helsingborg\App();


    // DESSA ÄR REFAKTORERADE TILL /LIB MAPPEN
    //require_once('library/theme-support.php');
    //require_once('library/navigation.php');
    //require_once('library/enqueue-scripts.php');
    //require_once('library/widget-areas.php');
    //require_once('library/meta-boxes.php');
    //require_once('library/helpers.php');

    require_once('library/helsingborg-ajax.php');
    require_once('meta_boxes/meta-functions.php');
    //require_once('library/scheduled-tasks.php');

    if (isset($_GET['flush-inactive']) && $_GET['flush-inactive'] == "true") {
        $widgets = get_option('sidebars_widgets');
        $widgets['wp_inactive_widgets'] = array();
        update_option('sidebars_widgets', $widgets);
        echo "Tog bort inaktiva widgets";
    }

    /*
    // Kör larm manuellt
    if (isset($_GET['dist'])) {
        require_once('library/scheduled-tasks/scheduled_alarms_disturbance.php');
        $hbgDistrubance = new HbgScheduledAlarmsDisturbance();
        $hbgDistrubance->createAlarmPages();
    }
    */

    /*
    // STÄNG AV ALLA KOMMENTARER FÖR HELA NÄTVERKET
    if (isset($_GET['bloglist'])) {
        global $wpdb;

        $blogs = get_blog_list(0, 'all');
        foreach ($blogs as $blog) {
            $wpdb->update("wp_{$blog['blog_id']}_posts", array('comment_status' => 'closed'), array('post_type' => 'page', 'post_type' => 'post'));
            echo "Kommentarer avstängda för: {$blog['path']}<br>";
        }

        exit;
    }
    */