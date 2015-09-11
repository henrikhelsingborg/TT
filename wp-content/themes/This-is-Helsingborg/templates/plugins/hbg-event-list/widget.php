<?php

    $featured = false;
    $featuredImage = false;
    if (isset($instance['post_id']) && $instance['post_id'] > 0) {
        $featured = get_page($instance['post_id']);

        $image_id = get_post_thumbnail_id($featured->ID);
        $featuredImage = wp_get_attachment_image_src($image_id, 'single-post-thumbnail');
    }

    include('widget-default.php');
?>