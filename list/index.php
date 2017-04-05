<?php

    $json = json_decode(file_get_contents('wp_blogs.json'));

    foreach ($json as $key => $site) {
        if (in_array($site->path, array("/", "/foretagare/"))) {
            continue;
        }

        if (isset($_GET['mapping'])) {
            echo '139.162.153.238 ';
        }

        echo trim($site->path, "/") . str_replace("www", "", $site->domain)."\n";
    }
