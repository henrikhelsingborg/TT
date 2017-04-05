<?php

/**
 * Tell WordPress to save the cookie on the domain
 * @var bool
 */

if (!isset($_SERVER['HTTP_HOST']) || (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], "helsingborg.dev") !== false)) {
    define('COOKIE_DOMAIN', ".helsingborg.dev");
} else {
    define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST']);
}
