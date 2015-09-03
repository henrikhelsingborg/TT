<?php

switch ($args['id']) {
    case 'slider-area':
        include('pinterest/slider-area.php');
        break;

    default:
        include('pinterest/default.php');
        break;
}