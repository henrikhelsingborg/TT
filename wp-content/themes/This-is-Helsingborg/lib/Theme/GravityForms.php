<?php

namespace Helsingborg\Theme;

class GravityForms
{
    /**
     * GravityForms adjustments and hooks
     */
    public function __construct()
    {
        // Add filter to add referer to gforms email notification
        add_filter('gform_pre_submission_filter', array($this, 'addRefererToNotification'));
    }

    /**
     * Append referer url to email notifications
     * @param array $data Form data
     */
    public function addRefererToNotification($data)
    {
        // Find the referer
        $referer = $_SERVER['HTTP_REFERER'];

        // Append referer to each notitification
        foreach ($data['notifications'] as &$notification) {
            $notification['message'] .= '<br><br>Sent from URL: <a href="' . $referer . '">' . $referer . '</a>';
        }

        // Return the data
        return $data;
    }
}
