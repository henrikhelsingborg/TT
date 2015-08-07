<?php

    require_once('library/theme-support.php');
    require_once('library/navigation.php');
    require_once('library/enqueue-scripts.php');
    require_once('library/widget-areas.php');
    require_once('library/helsingborg-ajax.php');
    require_once('library/meta-boxes.php');
    require_once('meta_boxes/meta-functions.php');
    require_once('library/helpers.php');
    require_once('library/scheduled-tasks.php');

    if (isset($_GET['flush-inactive']) && $_GET['flush-inactive'] == "true") {
        $widgets = get_option('sidebars_widgets');
        $widgets['wp_inactive_widgets'] = array();
        update_option('sidebars_widgets', $widgets);
        echo "Tog bort inaktiva widgets";
    }


    if (isset($_GET['dist'])) {
        require_once('library/scheduled-tasks/scheduled_alarms_disturbance.php');
        $hbgDistrubance = new HbgScheduledAlarmsDisturbance();
        $hbgDistrubance->createAlarmPages();
    }