<?php

/**
 * Outputs the breadcrumb
 * @return void
 */
function the_breadcrumb() {
    Helsingborg\Theme\Breadcrumb::outputBreadcrumb();
}

function get_excerpt_by_id($postId = 0) {
    Helsingborg\Helper\Wp::getExcerptById($postId);
}

function get_included_pages($post) {
    Helsingborg\Helper\Wp::getIncludedPages($post);
}