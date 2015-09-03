<?php

switch ($args['id']) {
    case 'slider-area':
        include('widget-slider.php');
        break;

    case 'content-area':
        include('widget-content-area.php');
        break;

    default:
        include('widget-default.php');
        break;
}