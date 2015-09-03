<?php

switch ($args['id']) {
    case 'slider-area':
        include('twitter/slider-area.php');
        break;

    default:
        include('twitter/default.php');
        break;
}