<?php

    $sidebars = array(
        'right-sidebar',
        'left-sidebar'
    );

    if (in_array($args['id'], $sidebars)) {
        include('widget-filled.php');
    } else {
        include('widget-outlined.php');
    }

?>