<?php

namespace HbgMigrate;

class WidgetSocial extends \HbgMigrate\Widget
{
    public $widgetType = 'helsingborgsocialwidget';
    public $moduleType = 'mod-social';

    public static $keys = array();

    /**
     * Rebuilds widget to module and saves it
     * @param  array  $data
     * @return bool|int         int (post_id) if succes, else false
     */
    public function migrate(array $widgetData, int $postId)
    {
        // Bail if no username
        if (!isset($widgetData['username']) || empty($widgetData['username'])) {
            return;
        }

        $data = array(
            'post_title' => isset($widgetData['title']) ? $widgetData['title'] : '',
            'post_content' => '',
            'acf' => array()
        );

        switch ($widgetData['feedType']) {
            case 'facebook':
                $data['acf'] = array(
                    'field_56dedc3548ed9' => 'facebook', // feed_type
                    'field_56dedd7948eda' => $this->getApiKey('facebook', 'public'), // Facebook app id
                    'field_56dedda248edb' => $this->getApiKey('facebook', 'secret'), // Facebook app secret
                    'field_56deddb348edc' => $widgetData['username'], // Facebook username
                );
                break;

            case 'instagram':
                $data['acf'] = array(
                    'field_56dedc3548ed9' => 'instagram', // feed_type
                    'field_56deddb348edc' => $widgetData['username'], // Instagram username
                    'field_56e038fa40a78' => $widgetData['col_count'] // Image columns
                );
                break;

            case 'twitter':
                $data['acf'] = array(
                    'field_56dedc3548ed9' => 'twitter', // feed_type
                    'field_56dee0e1ed7ab' => $this->getApiKey('twitter', 'public'), // Facebook app id
                    'field_56dee104ed7ac' => $this->getApiKey('twitter', 'secret'), // Facebook app secret
                    'field_56deddb348edc' => $widgetData['username'], // Instagram username
                    'field_56e038fa40a78' => $widgetData['col_count'] // Image columns
                );
                break;
        }

        $data['acf']['field_56dfe51e498cb'] = isset($widgetData['show_count']) && !empty($widgetData['show_count']) ? $widgetData['show_count'] : 10; // Max items
        $data['acf']['field_56e01f2577390'] = 300; // Max height

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }

    /**
     * Get api key
     * @param  string $provider
     * @param  string $key
     * @return string
     */
    public function getApiKey($provider, $key = 'public')
    {
        if (isset(self::$keys[$provider])) {
            return self::$keys[$provider][$key];
        }

        global $wpdbFrom;

        $public = '';
        $secret = '';

        switch ($provider) {
            case 'facebook':
                $public = $wpdbFrom->get_var("SELECT option_value FROM " . \HbgMigrate\MigrationEngine::getTable('options') . " WHERE option_name = 'hbgsf_facebook_app_id'");
                $secret = $wpdbFrom->get_var("SELECT option_value FROM " . \HbgMigrate\MigrationEngine::getTable('options') . " WHERE option_name = 'hbgsf_facebook_app_secret'");
                break;

            case 'instagram':
                $public = $wpdbFrom->get_var("SELECT option_value FROM " . \HbgMigrate\MigrationEngine::getTable('options') . " WHERE option_name = 'hbgsf_instagram_client_id'");
                break;

            case 'twitter':
                $public = $wpdbFrom->get_var("SELECT option_value FROM " . \HbgMigrate\MigrationEngine::getTable('options') . " WHERE option_name = 'hbgsf_twitter_consumer_key'");
                $secret = $wpdbFrom->get_var("SELECT option_value FROM " . \HbgMigrate\MigrationEngine::getTable('options') . " WHERE option_name = 'hbgsf_twitter_consumer_secret'");
                break;
        }

        self::$keys[$provider] = array(
            'public' => $public,
            'secret' => $secret
        );

        return self::$keys[$provider][$key];
    }
}

new \HbgMigrate\WidgetSocial();
