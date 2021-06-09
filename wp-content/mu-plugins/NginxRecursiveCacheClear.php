<?php

/*
Plugin Name: Nginx Helper Cache Clear Recursive
Description: Hooks into Nginx Helper plugin when url purge to clear recursive urls like query string etc.
Version:     1.0
Author:      Joel Bernerman, Helsingborg Stad
*/

namespace NginxRecursiveCacheClear;

class NginxRecursiveCacheClear
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Nginx helper wp cli command clears entire cache folder and will not be any use here.
        if (!defined('WP_CLI') && defined('RT_WP_NGINX_HELPER_CACHE_PATH')) {
            add_filter('rt_nginx_helper_purge_url', [$this, 'recursiveCacheClear'], 10, 1);
        }
    }

    /**
     * Cache clear recursive based on url.
     * @param string $url Url sent in filter.
     *
     * @return string $url Return url untouched.
     */
    public function recursiveCacheClear($url)
    {
        // Skip home url so we dont purge everything all the time.
        if ($url !== get_home_url() . '/') {
            // Build the cache key and add wildcard * in the end.
            $urlData = wp_parse_url($url);
            $cacheKey = $urlData['scheme'] . 'GET' . $urlData['host'] . $urlData['path'] . '.*';

            // Command to grep for key in cache files.
            $command = 'find ' . RT_WP_NGINX_HELPER_CACHE_PATH . ' -type f | ' .
                       'xargs --no-run-if-empty -n1000 grep -El -m 1 ' .
                       '"^KEY: ' . $cacheKey . '"';

            // Get recursive files and nuke em!
            $cacheFiles = [];
            exec($command, $cacheFiles);
            foreach ($cacheFiles as $cacheFile) {
                if (file_exists($cacheFile)) {
                    unlink($cacheFile);
                }
            }
        }
        return $url;
    }
}

new \NginxRecursiveCacheClear\NginxRecursiveCacheClear();
