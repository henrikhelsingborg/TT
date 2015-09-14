<?php

    switch ($args['id']) {
        case 'slider-area':
            include('widget-slider.php');
            break;

        case 'right-sidebar':
            include('widget-sidebar.php');
            break;

        default:
            include('widget-under.php');
            break;
    }