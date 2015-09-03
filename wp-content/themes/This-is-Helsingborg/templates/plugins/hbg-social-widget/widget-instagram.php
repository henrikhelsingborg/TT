<?php

switch ($args['id']) {
    case 'slider-area':
        include('instagram/slider-area.php');
        break;

    default:
        include('instagram/default.php');
        break;
}