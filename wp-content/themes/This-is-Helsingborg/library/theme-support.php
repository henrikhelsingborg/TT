<?php

/**
 * Adds theme support
 */
function HelsingborgThemeSupport() {
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
}
add_action('after_setup_theme', 'HelsingborgThemeSupport');

/**
 * Remove medium image size from media uploader
 */
function hbg_remove_image_size($sizes) {
    unset($sizes['medium']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'hbg_remove_image_size');