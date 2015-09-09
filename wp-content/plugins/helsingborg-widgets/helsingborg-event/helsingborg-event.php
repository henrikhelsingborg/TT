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

    /* Loads the list of event, to be presented inside a widget */
    add_action('wp_ajax_nopriv_update_event_calendar', 'update_event_calendar_callback');
    add_action('wp_ajax_update_event_calendar', 'update_event_calendar_callback');
    function update_event_calendar_callback() {
        $amount = $_POST['amount'];
        $ids    = $_POST['ids'];

        // Get the events
        $events = HelsingborgEventModel::load_events_simple($amount, $ids);

        $today = date('Y-m-d');
        $list = '';

        foreach( $events as $event ) {
            $list .= '<li>';
                $list .= '<a href="#" id="'.$event->EventID.'" class="event-item" data-reveal="eventModal"><span class="date">';
                    if ($today == $event->Date) {
                        $list .= '<span class="date-day"><strong>Idag</strong></span><span class="date-time">' . $event->Time . '</span>';
                    } else {
                        $list .= '<span class="date-day">' . date('d', strtotime($event->Date)) . '</span><span class="date-time">' . date('M', strtotime($event->Date)) . '</span>';
                    }
                $list .= '</span>';
                $list .= '<span class="title"><span class="link-item">' . $event->Name . '</span></span>';
                $list .= '</a>';
            $list .= '</li>';

            //$list .= '<a href="#" class="modalLink" id="'.$event->EventID.'" data-reveal-id="eventModal">'.$event->Name.'</a>';
        }

        $result = array('events' => $events, 'list' => $list);
        echo json_encode($result);

        die();
    }


    /* Load all organizers with event ID */
    add_action('wp_ajax_nopriv_load_event_organizers', 'load_event_organizers_callback');
    add_action('wp_ajax_load_event_organizers', 'load_event_organizers_callback');
    function load_event_organizers_callback() {
        $id     = $_POST['id'];
        $result = HelsingborgEventModel::get_organizers_with_event_id($id);
        echo json_encode($result);
        die();
    }

    /* Load all event times for a certain event ID */
    add_action( 'wp_ajax_nopriv_load_event_dates', 'load_event_dates_callback');
    add_action( 'wp_ajax_load_event_dates', 'load_event_dates_callback' );
    function load_event_dates_callback() {
        $id     = $_POST['id'];
        $result = HelsingborgEventModel::load_event_times_with_event_id($id);
        echo json_encode($result);
        die();
    }

    /* Load event types */
    add_action('wp_ajax_nopriv_load_event_types', 'load_event_types_callback');
    add_action('wp_ajax_load_event_types', 'load_event_types_callback' );
    function load_event_types_callback() {
        $result = HelsingborgEventModel::load_event_types();
        echo json_encode($result);
        die();
    }

    /* Load events */
    add_action('wp_ajax_nopriv_load_events', 'load_events_callback');
    add_action('wp_ajax_load_events', 'load_events_callback' );
    function load_events_callback() {
        $ids     = $_POST['ids'];
        $result = HelsingborgEventModel::load_events($ids);
        echo json_encode($result);
        die();
    }

    /* Add AJAX functions for admin. So Event may be changed by users
    Note: wp_ajax_nopriv_X is not used, since events cannot be changed by other than logged in users */
    /* Function for approving events, returns true if success. */
    add_action('wp_ajax_approve_event', 'approve_event_callback');
    function approve_event_callback() {
        global $wpdb;
        $id     = $_POST['id'];
        $result = HelsingborgEventModel::approve_event($id);
        die();
    }

    /* Function for denying events, returns true if success. */
    add_action('wp_ajax_deny_event', 'deny_event_callback');
    function deny_event_callback() {
        global $wpdb;
        $id     = $_POST['id'];
        $result = HelsingborgEventModel::deny_event($id);

        die();
    }

    /* Function for saving events, returns true if success. */
    add_action('wp_ajax_save_event',    'save_event_callback');
    function save_event_callback() {
        global $wpdb;

        $id          = $_POST['id'];
        $type        = $_POST['type'];
        $name        = $_POST['name'];
        $description = $_POST['description'];
        $link        = $_POST['link'];
        $days        = $_POST['days'];
        $start_date  = $_POST['startDate'];
        $end_date    = $_POST['endDate'];
        $time        = $_POST['time'];
        $units       = $_POST['units'];
        $types       = $_POST['types'];
        $organizer   = $_POST['organizer'];
        $location    = $_POST['location'];
        $imageUrl    = $_POST['imageUrl'];
        $author      = $_POST['author'];
        $days_array  = $_POST['days'];
        $days_array  = explode(',', $days_array);

        // Create event
        $event = array (
            'EventID'         => $id,
            'Name'            => $name,
            'Description'     => $description,
            'Link'            => $link,
            'Approved'        => $approved,
            'OrganizerID'     => $organizer,
            'Location'        => $location,
            'ExternalEventID' => $external_id,
        );

        // Event types
        $event_types_x  = explode(',', $types);
        $event_types = array();

        foreach ($event_types_x as $type) {
            $new_type = array('Name' => $type);
            array_push($event_types, $new_type);
        }

        // Administration units
        if ($units && !empty($units)){
            $administrations = explode(',', $units);

            foreach($administrations as $unit) {
                $administration_units[] = HelsingborgEventModel::get_administration_id_from_name($unit)->AdministrationUnitID;
            }
        }

        // Image
        $image = null;

        if ($imageUrl) {
            $image = array( 'ImagePath' => $imageUrl, 'Author' => $author);
        }

        // Create time/times
        $event_times = array();
        if (!$end_date) { // Single occurence
            $event_time = array(
                'Date'  => $start_date,
                'Time'  => $time,
                'Price' => 0
            );
            array_push($event_times, $event_time);
        } else { // Must be start and end then
            $dates_array = create_date_range_array($start_date, $end_date);
            $filtered_days = filter_date_array_by_days($dates_array, $days_array);

            foreach($filtered_days as $date) {
                $event_time = array(
                    'Date'  => $date,
                    'Time'  => $time,
                    'Price' => 0
                );
                array_push($event_times, $event_time);
                echo $date;
            }
        }

        HelsingborgEventModel::update_event($event, $event_types, $administration_units, $image, $event_times);

        die();
    }

    add_action('wp_ajax_hbgPostEventLoad', 'hbgPostEventLoad_callback');
    function hbgPostEventLoad_callback() {
        global $wpdb;

        $title = $_POST['q'];
        $list  = '';

        $posts = $wpdb->get_results("
            SELECT ID, post_title
            FROM $wpdb->posts
            WHERE post_type = 'page'
            AND post_status = 'publish'
            AND post_title LIKE '%" . $title . "%'
        ");

        $list .= '<option value="0">Ingen sida vald</option>';

        foreach ($posts as $post) {
            $list .= '<option value="' . $post->ID . '">';
            $list .= $post->post_title . ' (' . $post->ID . ')';
            $list .= '</option>';
        }

        echo $list;
        die();
    }