<?php

    switch ($args['id']) {
        case 'slider-area':
            include('widget-slider-area.php');
            break;

        case 'content-area':
            include('widget-content-area.php');
            break;


        default:
            include('widget-sidebar.php');
            break;
    }