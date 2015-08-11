<?php

function custom_comment_markup($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    include(STYLESHEETPATH . '/templates/partials/comment.php');
}

function disable_html() {
    global $allowedtags;
    $allowedtags = array();
}
disable_html();