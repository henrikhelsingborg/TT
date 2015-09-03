<?php

switch ($args['id']) {
    case 'slider-area':
        include('facebook/slider-area.php');
        break;

    default:
        include('facebook/default.php');
        break;
}