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
    }
    add_action('wp_enqueue_scripts', 'hbg_enqueue_scripts');

}