<?php
/*
  Plugin Name: Helsingborg Hjälp-enkät
  Description: Fråga besökarna om artikeln hjälpte dem.
  Version: 1.0
  Author: Kristoffer Svanmark
 */

define('HBGHELP_PATH', plugin_dir_path(__FILE__));
define('HBGHELP_URL', plugins_url('', __FILE__));

/**
 * Import required plugin files
 */
require_once(HBGHELP_PATH . 'classes/helsingborg-help-widget.php');

/**
 * Initialize
 */
add_action('widgets_init', 'hbgHelpWidgetRegister');
function hbgHelpWidgetRegister() {
    register_widget('HbgHelpWidget');
}

