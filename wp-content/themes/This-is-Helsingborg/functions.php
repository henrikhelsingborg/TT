<?php

    define('HELSINGBORG_PATH', get_template_directory());
    define('HELSINGBORG_URL', get_template_directory_uri());

    /**
     * THEME SETTINGS
     */
    $lazyloadImages = false;
    
    /**
    * MISC SETTINGS 
    */
    
    //Hidden ACF by default 
    if(!defined("ACF_LITE")){ define("ACF_LITE", true); }

    /**
     * THEME SETUP
     */
    require_once HELSINGBORG_PATH . '/lib/Vendor/Psr4ClassLoader.php';
    require_once HELSINGBORG_PATH . '/lib/Public.php';

    $loader = new Helsingborg\Vendor\Psr4ClassLoader();
    $loader->addPrefix('Helsingborg', HELSINGBORG_PATH);
    $loader->addPrefix('Helsingborg', HELSINGBORG_PATH . '/lib/');
    $loader->register();

    new Helsingborg\App();

    require_once('meta_boxes/meta-functions.php');

    if (isset($_GET['flush-inactive']) && $_GET['flush-inactive'] == "true") {
        $widgets = get_option('sidebars_widgets');
        $widgets['wp_inactive_widgets'] = array();
        update_option('sidebars_widgets', $widgets);
        echo "Tog bort inaktiva widgets";
    }

    // Kör larm manuellt
    if (isset($_GET['dist'])) {
        require(ABSPATH . 'wp-content/plugins/helsingborg-alarm/cron/scheduled_alarms_disturbance.php');
        $hbgDistrubance = new HbgScheduledAlarmsDisturbance();
        $hbgDistrubance->createAlarmPages();
    }

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