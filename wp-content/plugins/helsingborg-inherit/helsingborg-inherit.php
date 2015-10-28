<?php
/*
 * Plugin Name: Helsingborg Arvsinnehåll
 * Plugin URI: -
 * Description: Skapa innehåll till en widget som kan visas på flera sidor
 * Version: 1.0
 * Author: Kristoffer Svanmark
 * Author URI: -
 *
 * Copyright (C) 2015 Helsingborg stad
 */

define('HBG_INHERIT_TEMPLATE_FOLDER', 'hbg-inherit');
define('HBG_INHERIT_PATH', plugin_dir_path(__FILE__));
define('HBG_INHERIT_URL', plugins_url('', __FILE__));

require_once HBG_INHERIT_PATH . 'source/php/Vendor/Psr4ClassLoader.php';
require_once HBG_INHERIT_PATH . 'public.php';

// Include the ACF fields
require_once HBG_INHERIT_PATH . 'source/acf/OpeningHoursFields.php';
require_once HBG_INHERIT_PATH . 'source/acf/ContactFields.php';

// Instantiate and register the autoloader
$loader = new HbgInherit\Vendor\Psr4ClassLoader();
$loader->addPrefix('HbgInherit', HBG_INHERIT_PATH);
$loader->addPrefix('HbgInherit', HBG_INHERIT_PATH . 'source/php/');
$loader->register();

// Start application
new HbgInherit\App();
