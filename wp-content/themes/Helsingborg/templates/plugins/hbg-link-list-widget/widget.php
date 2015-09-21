<?php

    switch ($args['id']) {
        case 'right-sidebar':
            include('widget-sidebar.php');
            break;

        case 'left-sidebar':
            include('widget-sidebar.php');
            break;

        case 'left-sidebar-bottom':
            include('widget-sidebar.php');
            break;
        
        default:
            include('widget-default.php');
            break;
    }