<?php

    /**
     * Remove parent theme enqueue scripts action
     */
    add_action('after_setup_theme', 'remove_parent_theme_features', 10);
    function remove_parent_theme_features() {
        remove_action('wp_enqueue_scripts', 'hbgScripts');
    }

    add_action('wp_enqueue_scripts', 'child_theme_enqueue_styles_and_scripts');
    function child_theme_enqueue_styles_and_scripts() {
        // Remove emoji support
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles' );

        // Deregister jquery
        wp_deregister_script('jquery');
        wp_deregister_script('jquery-ui');
        wp_dequeue_script('jquery-ui');

        // Register app.jquery (includes jquery, jquery ui)
        wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/jquery.app.min.js', array(), '1.0.0', false);
        wp_enqueue_script('jquery');

        // Style.css
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style-app'));

        // App.js
        wp_register_script('foundation', get_stylesheet_directory_uri() . '/js/app.min.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('foundation');

        // Readspeaker
        wp_register_script('readspeaker', 'http://f1.eu.readspeaker.com/script/5507/ReadSpeaker.js?pids=embhl', array(), '1.0.0', false);
        wp_enqueue_script('readspeaker');

        // App.css
        wp_enqueue_style('style-app', get_stylesheet_directory_uri() . '/css/app.min.css');

        /**
         * Search
         */
        if (is_search()) {
            wp_register_script('app-search', get_stylesheet_directory_uri() . '/js/search.js', array(), '1.0.0', true);
            wp_enqueue_script('app-search');
        }

        /**
        * EVENT LIST PAGE
        **/
        if ( is_page_template( 'templates/event-list-page.php' )) {
            // Register scripts
            wp_register_script( 'zurb5-multiselect', get_template_directory_uri() . '/js/foundation-multiselect/zmultiselect/zurb5-multiselect.js', array(), '1.0.0', false );
            wp_register_script( 'jquery-datetimepicker', get_template_directory_uri() . '/js/jquery.datetimepicker.js', array(), '1.0.0', false );
            wp_register_script( 'knockout', get_template_directory_uri() . '/js/knockout/dist/knockout.js', array(), '3.2.0', false );
            wp_register_script( 'event-list-model', get_template_directory_uri() . '/js/helsingborg/event_list_model.js', array(), '1.0.0', false );

            // Register styles
            wp_register_style( 'zurb5-multiselect', get_template_directory_uri() . '/css/multiple-select.css', array(), '1.0.0', 'all' );
            wp_register_style( 'jquery-datetimepicker', get_template_directory_uri() . '/js/jquery.datetimepicker.css', array(), '1.0.0', 'all' );

            // Enqueue scripts
            wp_enqueue_script('zurb5-multiselect');
            wp_enqueue_script('jquery-datetimepicker');
            wp_enqueue_script('knockout');
            wp_enqueue_script('event-list-model');

            // Enqueue styles
            wp_enqueue_style('zurb5-multiselect');
            wp_enqueue_style('jquery-datetimepicker');
        }
    }