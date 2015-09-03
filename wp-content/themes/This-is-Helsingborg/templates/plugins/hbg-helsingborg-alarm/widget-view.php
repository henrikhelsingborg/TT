<?php

    switch ($args['id']) {
        case 'slider-area':
            include('widget-slider-area.php');
            break;

        default:
            inclide('widget-sidebar.php');
            break;
    }