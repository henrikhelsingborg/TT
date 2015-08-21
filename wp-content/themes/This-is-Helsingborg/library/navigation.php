<?php

/**
 * Register menus
 */
register_nav_menus(array(
    'main-menu' => 'Huvudmeny',
    'top-menu' => 'Toppmeny',
    'footer-menu' => 'Hjälpmeny'
));

/**
 * Prints the breadcrumb
 * @return [type] [description]
 */
function the_breadcrumb() {
    global $post;

    $title = get_the_title();
    $output = '';

    echo '<ul class="breadcrumbs">';

    if (!is_front_page()) {
        if (is_category() || is_single()) {
            echo '<li>';
            the_category('<li>');

            if (is_single()) {
                echo '<li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if($post->post_parent) {
                $anc = get_post_ancestors($post->ID);
                $title = get_the_title();

                foreach ($anc as $ancestor) {
                    if (get_post_status($ancestor) != 'private') {
                        $output = '<li><a href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li></li>' . $output;
                    }
                }

                echo $output;
                echo '<span class="breadcrumbs-current" title="' . $title . '">' . $title . '</span>';
            } else {
                echo '<li><span class="breadcrumbs-current">' . get_the_title() . '</span></li>';
            }
        }
    }
    echo '</ul>';
}