<?php

    switch ($args['id']) {
        case 'right-sidebar':
            include('widget-filled.php');
            break;

        case 'left-sidebar':
            include('widget-filled.php');
            break;

        case 'slider-area':
            include('widget-slider-area.php');
            break;

        default:
            include('widget-outlined.php');
            break;
    }

?>