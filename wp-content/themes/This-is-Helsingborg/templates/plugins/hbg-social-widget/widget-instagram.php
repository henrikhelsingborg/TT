<?php

switch ($args['id']) {
    case 'slider-area':
        include('instagram/slider-area.php');
        break;

    case 'right-sidebar':
        include('instagram/sidebar-area.php');
        break;

    case 'left-sidebar':
        include('instagram/sidebar-area.php');
        break;

    default:
        include('instagram/default.php');
        break;
}