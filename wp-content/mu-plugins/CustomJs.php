<?php

add_action('acf/init', function () {
    $customjs = get_field('custom_js_input', 'option');
    $shouldUpdate = false;

    // Add Vergic code if missing
    if (strpos($customjs, '// --Vergic--') === false) {
        $shouldUpdate = true;
        $customjs .= '

// --Vergic--
(function (server, psID) {
    var s = document.createElement(\'script\');
    s.type = \'text/javascript\';
    s.src = server + \'/\' + psID + \'/ps.js\';
    document.getElementsByTagName(\'head\')[0].appendChild(s);
}(\'https://account.psplugin.com\', \'331F5271-4B0B-4625-BF08-4157F101DBFF\'));';
    }

    // Add Vergic code if missing
    if (strpos($customjs, '// --Google Tag Manager--') === false) {
        $shouldUpdate = true;
        $customjs .= '

// --Google Tag Manager--
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
\'//www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,\'script\',\'dataLayer\',\'GTM-PVK49V\');
        ';
    }

    // Update if needed
    if ($shouldUpdate) {
        update_field('custom_js_input', $customjs, 'option');
    }
});
