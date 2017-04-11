<?php

add_action('acf/init', function () {
    $customjs = get_field('custom_js_input', 'option');
    $shouldUpdate = false;

    // Add Vergic code if missing
    if (strpos($customjs, 'https://account.psplugin.com') < 0) {
        $shouldUpdate = true;
        $customjs .= '(function (server, psID) {
                var s = document.createElement(\'script\');
                s.type = \'text/javascript\';
                s.src = server + \'/\' + psID + \'/ps.js\';
                document.getElementsByTagName(\'head\')[0].appendChild(s);
            }(\'https://account.psplugin.com\', \'331F5271-4B0B-4625-BF08-4157F101DBFF\'));';
    }

    if ($shouldUpdate) {
        update_field('custom_js_input', $customjs, 'option');
    }
});
