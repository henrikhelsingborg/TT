<?php

switch ($args['id']) {
    case 'slider-area':
        include('widget-slider.php');
        break;

    case 'content-area':
        include('widget-content-area.php');
        break;

    case 'content-area-bottom':
        include('widget-content-area.php');
        break;

    case 'right-sidebar':
        include('widget-sidebar.php');
        break;

    case 'left-sidebar':
        include('widget-sidebar.php');
        break;

    default:
        include('widget-slider.php');
        break;
}