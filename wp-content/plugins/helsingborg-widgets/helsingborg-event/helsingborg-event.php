<?php

    include_once('classes/helsingborg-event-list-widget.php');
    require_once('models/event_model.php');

    $EventList = new EventList();


   /**
    * Add scheduled work for CBIS events
    * @return void
    */
    require_once('cron/scheduled_cbis.php');
    function setup_scheduled_cbis() {
      if ( ! wp_next_scheduled( 'scheduled_cbis' ) ) {
        // Set scheduled task to occur at 22.30 each day
        wp_schedule_event( strtotime(date("Y-m-d", time()) . '22:30'), 'daily', 'scheduled_cbis');
      }
    }
    add_action('wp', 'setup_scheduled_cbis');

    /**
     * Add scheduled work for XCap events
     * @return void
     */
    require_once('cron/scheduled_xcap.php');
    function setup_scheduled_xcap() {
      if ( ! wp_next_scheduled( 'scheduled_xcap' ) ) {
        // Set scheduled task to occur at 22.30 each day
        wp_schedule_event( strtotime(date("Y-m-d", time()) . '22:30'), 'daily', 'scheduled_xcap');
      }
    }
    add_action('wp', 'setup_scheduled_xcap');

    /* Manually start fetch of XCap */
    add_action('wp_ajax_start_manual_xcap', 'start_manual_xcap_callback');
    function start_manual_xcap_callback() {
        xcap_event();
    }

    /* Manually start fetch of CBIS */
    add_action('wp_ajax_start_manual_cbis', 'start_manual_cbis_callback');
    function start_manual_cbis_callback() {
        cbis_event();
    }