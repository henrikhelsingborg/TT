<?php

class EventListWidgetIcs {

    private $_viewsPath;

    public function __construct()
    {
        $this->_viewsPath = plugin_dir_path(plugin_dir_path(__FILE__)) . 'views/';
    }

    public function formatDate($dateString, $mod = null)
    {
        $date = new DateTime($dateString);

        if ($mod) {
            $date->modify($mod);
        }

        return $date->format('Ymd\THis');
    }

    public function escapeString($string)
    {
        return preg_replace('/([\,;])/','\\\$1', $string);
    }

    public function download($eventID)
    {
        $eventModel = new HelsingborgEventModel;
        $event = $eventModel->load_event_with_event_id($eventID);

        header('Content-type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename=event-' . strtolower(sanitize_file_name($event->Name)) . '.ics');

        $view = 'event-download-isc.php';
        if ($templatePath = locate_template('templates/plugins/hbg-event-list/' . $view)) {
           require($templatePath);
        } else {
            require($this->_viewsPath . $view);
        }

        exit();
    }

}