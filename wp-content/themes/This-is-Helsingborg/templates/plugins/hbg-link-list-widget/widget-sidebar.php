<?php
    $today = date('Y-m-d');
    echo $before_widget;

    if ($args['id'] == 'slider-area') {
        include_once('slider-area.php');
    } else {
        include_once('sidebar-area.php');
    }

    echo $after_widget;
?>