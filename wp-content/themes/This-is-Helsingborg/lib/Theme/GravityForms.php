<?php

namespace Helsingborg\Theme;

class GravityForms
{
    
    public function __construct()
    {
        add_filter('gform_pre_submission_filter', array($this, 'addRefererToNotification'));
    }

    public function addRefererToNotification($data)
    {
        $referer = $_SERVER['HTTP_REFERER'];

        foreach ($data['notifications'] as &$notification) {
            $notification['message'] .= '<br><br>Sent from URL: <a href="' . $referer . '">' . $referer . '</a>';
        }

        return $data;
    }

}