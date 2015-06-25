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
        /**
         * Search result page
         */
        if (is_search()) {
            wp_register_script('app-search', get_template_directory_uri() . '/assets/js/dist/search.min.js', array(), '1.0.0', true);
            wp_enqueue_script('app-search');
        }

        if (is_page_template('templates/event-search.php')) {
            wp_register_script('knockout', get_template_directory_uri() . '/assets/js/dist/knockout.js', array(), '3.3.0', false);
            wp_enqueue_script('knockout');

            wp_register_script('event-list-model', get_template_directory_uri() . '/assets/js/dist/event.js', array(), '1.0.0', false);
            wp_enqueue_script('event-list-model');
        }
    }

    /**
     * Admin specific scripts to enqueue
     * @return void
     */
    function load_custom_wp_admin_style() {
        wp_register_style('custom_wp_admin_css', get_template_directory_uri() . '/assets/css/dist/admin-hbg.css', array(), '1.0.0');
        wp_enqueue_style('custom_wp_admin_css');

        wp_register_script('jquery-ui', get_template_directory_uri() . '/assets/js/dist/jquery-ui.min.js', array(), '1.0.0', false);
        //wp_register_script('select2' , (get_template_directory_uri() . '/assets/js/helsingborg/select2.min.js'), array(), '1.0.0', false);

        wp_enqueue_script('jquery-ui');
        //wp_enqueue_script('select2');
    }
    add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');

}