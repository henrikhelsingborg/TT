<?php

if (isset($_GET['migrate']) && $_GET['migrate'] === 'yes-please') {
    global $wpdbFrom;
    $wpdbFrom = new \wpdb(DB_USER, DB_PASSWORD, 'hbg_old', DB_HOST);


    // Include all migration scripts from the hbg-migrate folder
    foreach (glob(__DIR__ . '/hbg-migrate/*.php') as $migrate) {
        require_once $migrate;
    }

    exit;
}
