<?php

    $json = json_decode(file_get_contents('wp_blogs.json'));

    foreach($json as $key => $site) {

        if (in_array($site->path, array("/","/foretagare/"))) {
            continue;
        }
        echo trim($site->path, "/") . str_replace("www", "", $site->domain)."\n";
    }
