<?php
    $today = date('Y-m-d');
    echo $before_widget;

    if ($args['id'] == 'slider-area') {
        include('slider-area.php');
    } else {
        include('sidebar-area.php');
    }

    echo $after_widget;
?>