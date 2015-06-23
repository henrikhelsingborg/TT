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

    $base_pages = get_children( $args );
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