<?php

// Save Google Analytics key for all sites in network

namespace SaveAnalyticsKey;

class SaveAnalyticsKey
{
    public $key = "UA-XXXXX-Y";

    public function __construct()
    {
        if (isset($_GET['save-analytics']) && $_GET['save-analytics'] == 'true') {
            add_action('init', array($this, 'saveKey'), 20);
        }
    }

    public function saveKey()
    {
        $sites = get_sites();
        $updated = array();

        if (is_array($sites) && !empty($sites)) {
            foreach ($sites as $key => $site) {
                switch_to_blog($site->blog_id);
                $update = update_field('field_56c5c4de2d2a6', $this->key, 'option');
                $updated[$site->blog_id] = array(
                                'blog_id' => $site->blog_id,
                                'domain'  => $site->domain,
                                'path'    => $site->path,
                                'updated' => ($update) ? 'true' : 'false',
                            );
                restore_current_blog();
            }
        }

        echo "<pre>";
        print_r($updated);

        exit;
    }
}

new \SaveAnalyticsKey\SaveAnalyticsKey();
