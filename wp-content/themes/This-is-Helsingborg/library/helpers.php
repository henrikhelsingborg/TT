<?php

/*
 * Function for displaying proper IDs depending on current location,
 * used by wp_include_pages for the menus.
 */
function get_included_pages($post) {
    $includes = array();
    $args = array(
        'post_type'   => 'page',
        'post_status' => 'publish',
        'post_parent' => get_option('page_on_front'),
    );

    $base_pages = get_children($args);
    foreach($base_pages as $page) {
        array_push($includes, $page->ID);
    }

    if ($post) {
        $ancestors = get_post_ancestors($post);
        array_push($ancestors, strval($post->ID));

        foreach ($ancestors as $ancestor) {
            $args = array(
                'post_type'   => 'page',
                'post_status' => 'publish',
                'post_parent' => $ancestor,
            );

            $childs = get_children( $args );

            foreach ($childs as $child) {
                array_push($includes, $child->ID);
            }

            array_push($includes, $ancestor);
        }
    }

    return implode(',', $includes);
}

/**
 * Filters empty tags from post content
 * @param  string $content The post content
 * @return string          Filtered post content
 */
function remove_empty_p($content) {
    // clean up p tags around block elements
    $content = preg_replace( array(
        '#<p>\s*<(div|aside|section|article|header|footer)#',
        '#</(div|aside|section|article|header|footer)>\s*</p>#',
        '#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
        '#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
        '#<p>\s*</(div|aside|section|article|header|footer)#',
        '#<p>(\s|&nbsp;)*+(<br\s*/*>)?(\s|&nbsp;)*</p>#'
    ), array(
        '<$1',
        '</$1>',
        '</$1>',
        '<$1$2>',
        '</$1',
    ), $content );

    return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content);
}
add_filter('the_content', 'remove_empty_p', 20, 1);