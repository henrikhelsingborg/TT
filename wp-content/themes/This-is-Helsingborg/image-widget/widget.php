<?php

switch ($args['id']) {
    case 'slider-area':
        include('widget-slider-area.php');
        break;

    case 'content-area':
        if (is_front_page()) {
            include('widget-content-area-front.php');
        } else {
            include('widget-content-area.php');
        }

        break;

    case 'content-area-bottom':
        include('widget-content-area.php');
        break;

    default:
        include('widget-default.php');
        break;
}