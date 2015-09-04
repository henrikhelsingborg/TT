<?php

switch ($args['id']) {
    case 'slider-area':
        include('twitter/slider-area.php');
        break;

    case 'right-sidebar':
        include('twitter/sidebar-area.php');
        break;

    case 'left-sidebar':
        include('twitter/sidebar-area.php');
        break;

    default:
        include('twitter/default.php');
        break;
}