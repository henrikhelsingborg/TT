<?php
/**
 * Plugin Name: Disable JSON API
 * Description: Remove JSON API 
 * Version: 1.0
 * Author: Sebastian Thulin 
 * License: GPL2
 */

// Filters for WP-API version 1.x
add_filter('json_enabled', '__return_false');
add_filter('json_jsonp_enabled', '__return_false');

// Filters for WP-API version 2.x
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');

//Remove from header 
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );