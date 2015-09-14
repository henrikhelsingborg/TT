<?php

/*
 * Plugin Name: Helsingborg Widgets
 * Plugin URI: -
 * Description: Skapar en samling med Widgets anpassade för Helsingborg stad
 * Version: 1.0
 * Author: Henric Lind
 * Author URI: -
 *
 * Copyright (C) 2014 Helsingborg stad
 */


/**
 * Include settings page
 */
include_once('helsingborg-settings.php');

/**
 * Include all plugin widgets and stuff
 */
function includeHbgWidgets() {
    $basedir = plugin_dir_path(__FILE__);

    $exclude = array(
        'assets',
        'js',
        'slider-widget',
        'post_author',
        'helsingborg-settings',
        'helsingborg-post-thumbnail',
    );

    $plugins = glob($basedir . '*', GLOB_ONLYDIR);

    foreach ($plugins as $plugin) {
        $plugin = basename($plugin);
        //var_dump(in_array($plugin, $exclude), $plugin);
        if (!in_array($plugin, $exclude)) {
            include_once($basedir . '' . $plugin . '/' . $plugin . '.php');
        }
    }
}

includeHbgWidgets();


/**
 * Add resources used by link-list-widget
 */
add_action('admin_enqueue_scripts', 'hbgWidgetAdminEnqueue');
function hbgWidgetAdminEnqueue () {
    wp_enqueue_style( 'helsingborg-widgets-css', plugin_dir_url(__FILE__) .'assets/css/helsingborg-widgets.css');
    wp_enqueue_script( 'jquery', get_template_directory_uri() . 'js/jquery/dist/jquery.min.js');
    wp_enqueue_script( 'helsingborg-list-sort-js', plugin_dir_url(__FILE__) .'assets/js/helsingborg-list-sort.js');
    wp_enqueue_script( 'helsingborg-media-selector-original-js', plugin_dir_url(__FILE__) .'assets/js/helsingborg-media-selector-original.js');
    wp_enqueue_script( 'steps-js', plugin_dir_url(__FILE__) . 'assets/js/steps.js');
}

/**
 * Function to purge the cache of a specific page_id/post_id when page widgets is updated
 */
if (!function_exists("hbg_purge_page")) {
    function hbg_purge_page($args) {
        $post_id = $args['post_id'];
        if (function_exists('w3tc_pgcache_flush_post')){
            w3tc_pgcache_flush_post($post_id);
            //print '<!-- Post with id ' . $post_id . ' purged -->';
        }
    }
    add_filter('hbg_page_widget_save', 'hbg_purge_page');
}

if (!function_exists('')) {
    function is_external_url($external_url, $internal_url = null) {
        if (!$internal_url) $internal_url = 'http://' . $_SERVER['SERVER_NAME'];

        $url_host = parse_url($external_url, PHP_URL_HOST);
        $base_url_host = parse_url($internal_url, PHP_URL_HOST);

        if ($url_host == $base_url_host || empty($url_host)) {
            return false;
        } else {
            return true;
        }
    }
}


/**
 * AJAX FUNCTIONS
 */

/* Loads pages where post_title has keyword $title */
add_action('wp_ajax_load_page_with_id', 'load_page_with_id_callback');
function load_page_with_id_callback() {
    global $wpdb;

    $id        = $_POST['id'];
    $sql = "SELECT ID, post_title FROM $wpdb->posts WHERE ID = " . $id;
    $pages = $wpdb->get_results($sql);

    if ($pages) {$page = $pages[0];} else {die();}

    echo $page->post_title . '|' . get_permalink($page->ID);

    die();
}

/* Loads pages where post_title has keyword $title */
add_action('wp_ajax_load_pages_with_update', 'load_pages_with_update_callback');
function load_pages_with_update_callback() {
    global $wpdb;

    $title     = $_POST['title'];
    $id        = $_POST['id'];
    $num       = $_POST['num'];
    $update    = $_POST['update'];

    if (is_numeric($title)) {
        $sql = "SELECT ID, post_title FROM $wpdb->posts WHERE ID = " . $title;
    } else {
        $sql = "SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'page' AND post_title LIKE '%" . $title . "%'";
    }

    $pages = $wpdb->get_results($sql);

    $onchange = '';

    if ($update) {
        $onchange = 'onchange="'.$update.'(\''.$id.'\', \''.$num.'\')"';
    }

    $list = '<select '.$onchange.' id=\'select_' . $id . $num . '\'">';
    $list .= '<option value="-1">' . __(" -- Välj sida i listan -- ") . '</option>';

    foreach ($pages as $page) {
        $list .= '<option value="' . $page->ID . '">';
        $list .= $page->post_title . ' (' . $page->ID . ')';
        $list .= '</option>';
    }

    $list .= '</select>';

    echo $list;
    die();
}


