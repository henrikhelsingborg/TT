<?php

if (!function_exists('hbg_enqueue_scripts')) {

    /**
     * Registers all nececarry scripts and styles and includes them in wp_head()
     * @return void
     */
    function hbg_enqueue_scripts() {
        // Remove emoji support
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles' );

        // Deregister jquery
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-ui');
        wp_dequeue_script('jquery-ui');

        // Register packaged jQuery + jQuery UI
        wp_register_script('jquery', get_template_directory_uri() . '/assets/js/dist/packaged.jquery.min.js', array(), '1.0.0', false);
        wp_enqueue_script('jquery');

        // Readspeaker
        wp_register_script('readspeaker', 'http://f1.eu.readspeaker.com/script/5507/ReadSpeaker.js?pids=embhl', array(), '1.0.0', false);
        wp_enqueue_script('readspeaker');

        /**
         * Register app.min.js
         */
        wp_register_script('app', get_template_directory_uri() . '/assets/js/dist/app.min.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('app');

        /**
         * Stylesheet
         */
        wp_enqueue_style('style-app', get_template_directory_uri() . '/assets/css/dist/app.min.css');

        hbgPageSpecificScripts();
    }
    add_action('wp_enqueue_scripts', 'hbg_enqueue_scripts');

    function hbgPageSpecificScripts() {
        wp_register_script('knockout', get_template_directory_uri() . '/assets/js/dist/knockout.js', array(), '3.3.0', false);

        /**
         * Search result page
         */
        if (is_search()) {
            wp_register_script('app-search', get_template_directory_uri() . '/assets/js/dist/search.min.js', array(), '1.0.0', true);
            wp_enqueue_script('app-search');
        }

        /**
         * Event search page
         */
        if (is_page_template('templates/event-search.php')) {
            wp_enqueue_script('knockout');

            wp_register_script('event-list-model', get_template_directory_uri() . '/assets/js/dist/event.min.js', array(), '1.0.0', false);
            wp_enqueue_script('event-list-model');
        }

        /**
         * Alarm search page
         */
        if (is_page_template('templates/alarm-search.php')) {
            wp_enqueue_script('knockout');

            wp_register_script('alarm-list-page', get_template_directory_uri() . '/assets/js/dist/alarm.js', array(), '1.0.0', false);
            wp_enqueue_script('alarm-list-page');
        }

        /**
         * List page
         */
        if (is_page_template('templates/list-page.php')) {
            wp_enqueue_script('knockout');
        }
    }

    /**
     * Admin specific scripts to enqueue
     * @return void
     */
    function load_custom_wp_admin_style() {
        wp_register_style('custom_wp_admin_css', get_template_directory_uri() . '/assets/css/dist/admin.min.css', array(), '1.0.0');
        wp_enqueue_style('custom_wp_admin_css');

        wp_register_script('jquery-ui', get_template_directory_uri() . '/assets/js/dist/jquery-ui.min.js', array(), '1.0.0', false);
        wp_register_script('custom-admin', get_template_directory_uri() . '/assets/js/dist/admin.min.js', array(), '1.0.0', false);

        wp_enqueue_script('jquery-ui');
        wp_enqueue_script('custom-admin');
    }
    add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');

}