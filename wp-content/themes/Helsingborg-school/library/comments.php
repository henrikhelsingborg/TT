<?php

function custom_comment_markup($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    include(STYLESHEETPATH . '/templates/partials/comment.php');
}