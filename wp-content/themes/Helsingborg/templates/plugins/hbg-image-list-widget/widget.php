<?php

    switch ($args['id']) {
        case 'left-sidebar':
            include('widget-sidebar.php');
            break;

        case 'left-sidebar-bottom':
            include('widget-sidebar.php');
            break;

        case 'right-sidebar':
            include('widget-sidebar.php');
            break;

        case 'slider-area':
            include('widget-slider.php');
            break;
        
        default:
            include('widget-default.php');
            break;
    }