<?php

/**
 * Outputs the breadcrumb
 * @return void
 */
function the_breadcrumb() {
    Helsingborg\Theme\Breadcrumb::outputBreadcrumb();
}

/**
 * Get the excerpt by post id
 * @param  integer $postId The post id
 * @return string          The excerpt
 */
function get_excerpt_by_id($postId = 0) {
    Helsingborg\Helper\Wp::getExcerptById($postId);
}

/**
 * Get included pages by post
 * @param  integer $post Post id
 * @return array         Inluded pages
 */
function get_included_pages($post) {
    Helsingborg\Helper\Wp::getIncludedPages($post);
}