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

/**
 * Cron interval used by our schedule events
 * @param  [type] $schedules [description]
 * @return [type]            [description]
 */
function cron_add_3min($schedules) {
    $schedules['3min'] = array(
        'interval' => 3*60,
        'display'  => __('Once every three minutes')
    );

    return $schedules;
}
add_filter('cron_schedules', 'cron_add_3min');