<?php

switch ($args['id']) {
    case 'slider-area':
        include('facebook/slider-area.php');
        break;


    case 'right-sidebar':
        include('facebook/sidebar-area.php');
        break;

    case 'left-sidebar':
        include('facebook/sidebar-area.php');
        break;

    default:
        include('facebook/default.php');
        break;
}