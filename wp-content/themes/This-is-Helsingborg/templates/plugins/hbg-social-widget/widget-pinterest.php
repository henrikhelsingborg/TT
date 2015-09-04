<?php

switch ($args['id']) {
    case 'slider-area':
        include('pinterest/slider-area.php');
        break;

    case 'right-sidebar':
        include('pinterest/sidebar-area.php');
        break;

    case 'left-sidebar':
        include('pinterest/sidebar-area.php');
        break;

    default:
        include('pinterest/default.php');
        break;
}