<?php
/*
 * Plugin Name: Alameringswidget
 * Plugin URI: -
 * Description: Skapar en widget för att visa alarm samt möjlighet att lägga till karta.
 * Version: 1.0
 * Author: Henric Lind
 * Author URI: -
 *
 * Copyright (C) 2014 Helsingborg stad
 */
define('HELSINGBORG_ALARM_BASE', WP_PLUGIN_URL."/".dirname( plugin_basename( __FILE__ ) ) );
define('ALARM_MARKERS_BASE_URL', 'http://alarmservice.helsingborg.se/AlarmServices.svc/GetAlarmMarkers/');
define('ALARM_FOR_CITIES_URL'  , 'http://alarmservice.helsingborg.se/AlarmServices.svc/GetAlarmsForCities/');

// Require alarm class/model
require_once('models/alarm_model.php');


// Include the neccessary classes
include_once('classes/alarm-widget.php');
include_once('classes/alarm-shortcode.php');
$AlarmList = new AlarmList();

/**
 * AJAX function for retrieving markers from AlarmService
 **/
add_action( 'wp_ajax_get_markers', 'get_markers_callback' );
add_action( 'wp_ajax_nopriv_get_markers', 'get_markers_callback' );
function get_markers_callback() {
  $options = $_GET['options'];
  $url = ALARM_MARKERS_BASE_URL . urlencode($options);
  $result = file_get_contents($url);
  die($result);
}

/**
* AJAX function for retrieving full alarms from AlarmService
**/
add_action( 'wp_ajax_get_alarm_for_cities', 'get_alarm_for_cities_callback' );
add_action( 'wp_ajax_nopriv_get_alarm_for_cities', 'get_alarm_for_cities_callback' );
function get_alarm_for_cities_callback() {
  $options = $_GET['options'];
  $url = ALARM_FOR_CITIES_URL . urlencode($options);
  $result = file_get_contents($url);
  die($result);
}

// Simple function for encoding the values only, not the delimiters
function encode_values($options, $delimiter_in, $delimiter_out) {
  $values = explode($delimiter_in, $options);
  $encoded_values = array();
  foreach($values as $value) {
    array_push($encoded_values, urlencode($value));
  }
  return implode($delimiter_out, $values);
}


/**
 * Add scheduled work for alarm
 * @return void
 */
require_once('cron/scheduled_alarms.php');
function setup_scheduled_alarms() {
    if ( ! wp_next_scheduled( 'scheduled_alarms' ) ) {
        // Set scheduled task to occur each 3rd minute
        wp_schedule_event(time(), '3min', 'scheduled_alarms');
    }
}
add_action('wp', 'setup_scheduled_alarms');

/* Manually start fetch of alarms */
add_action('wp_ajax_start_manual_alarms', 'start_manual_alarms_callback');
function start_manual_alarms_callback() {
    alarms_event();
}

/* Loads the big notifications i.e. warning/information and prints the alert messages */
/* The IDs being fetched are set from Helsingborg settings */
add_action('wp_ajax_nopriv_big_notification', 'big_notification_callback');
add_action('wp_ajax_big_notification', 'big_notification_callback');
function big_notification_callback() {
    global $wpdb;
    $disturbances = array();
    $informations = array();

    // Get the parent IDs from where the notifications are being fetched
    $disturbance_root_id = get_option('helsingborg_big_disturbance_root');
    $information_root_id = get_option('helsingborg_big_information_root');

    // Get the child pages for these IDs
    $wp_query     = new WP_Query();
    $all_wp_pages = $wp_query->query(array('post_type' => 'page'));

    // Get the children
    if ($disturbance_root_id != '') $disturbances = get_page_children($disturbance_root_id, $all_wp_pages);
    if ($information_root_id != '') $informations = get_page_children($information_root_id, $all_wp_pages);

    // Merge the notifications and sort the new array by date
    $notifications = array_merge($disturbances, $informations);

    // No notifications to show, just die
    if (!$notifications) {die();}

    // Sort all notifications by date
    usort($notifications, create_function('$a,$b', 'return strcmp($b->post_date, $a->post_date);'));

    $retArr = array();

    // Print the alarms
    foreach($notifications as $notification) {
        $class = in_array($notification, $disturbances, TRUE) ? 'warning' : 'info';
        $link = get_permalink($notification->ID);
        $the_content = get_extended($notification->post_content);
        $main = strip_tags($the_content['main']);
        if (strlen($main) > 50) $main = trim(substr($main, 0, 100)) . "…";
        $content = $the_content['extended'];

        $retArr[] = array(
            'class' => $class,
            'link' => $link,
            'main' => $main,
            'title' => $notification->post_title
        );
    }

    echo json_encode($retArr);

    // Return
    wp_die();
}

/* Load all alarms */
add_action('wp_ajax_nopriv_load_alarms', 'load_alarms_callback');
add_action('wp_ajax_load_alarms', 'load_alarms_callback');
function load_alarms_callback() {
    $result = HelsingborgAlarmModel::load_alarms();
    echo json_encode($result);
    die();
}
