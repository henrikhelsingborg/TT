<?php
    $today = date('Y-m-d');
    echo $before_widget;

    switch ($args['id']) {
        case 'slider-area':
            include('slider-area.php');
            break;

        case 'right-sidebar':
            include('sidebar-area.php');
            break;

        case 'left-sidebar':
            include('sidebar-area.php');
            break;

        case 'left-sidebar-bottom':
            include('sidebar-area.php');
            break;

        default:
            include('widget-default.php');
            break;
    }

    echo $after_widget;
?>