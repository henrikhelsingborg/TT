<?php

    require('library/enqueue-scripts.php');
    require('library/widget-areas.php');
    require_once('library/helsingborg-ajax.php');

    /*
    if (isset($_GET['flush-inactive']) && $_GET['flush-inactive'] == "true") {
        $widgets = get_option('sidebars_widgets');
        $widgets['wp_inactive_widgets'] = array();
        update_option('sidebars_widgets', $widgets);
        echo "Tog bort inaktiva widgets";
    }
    */