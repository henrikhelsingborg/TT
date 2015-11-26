<?php

    /**
     * Set document headers to json and prevent caching
     */
    header("Content-type: application/json; charset=utf-8");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    /**
     * Load wordpress dependencies
     */
    $path = $_SERVER['DOCUMENT_ROOT'];
    require_once $path . '/wp-load.php';
    require_once 'models/event_model.php';

    /**
     * Load events
     */
    $numEvents = 10;
    if (isset($_GET['count']) && is_numeric($_GET['count']) && $_GET['count'] > 0) {
        $numEvents = $_GET['count'];
    }

    $eventModel = new HelsingborgEventModel;
    $events = $eventModel->load_events_simple($numEvents);


    echo json_encode($events);
