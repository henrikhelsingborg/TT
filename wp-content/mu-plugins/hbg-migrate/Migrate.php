<?php

namespace HbgMigrate;

class Migrate
{
    public $postType;

    protected $activeDb = 'to';

    protected $fromDb;
    protected $toDb;

    protected $failed = array();

    public function __construct()
    {
        global $wpdb, $wpdbFrom;

        $this->toDb = $wpdb;
        $this->fromDb = $wpdbFrom;

        $this->start(0, 100);
    }

    /**
     * Start migration process
     * @param  int|integer $offset
     * @param  int|integer $perPage
     * @return void
     */
    public function start(int $offset = 0, int $perPage = 100)
    {
        $posts = get_posts(array(
            'posts_per_page' => $perPage,
            'offset' => $offset,
            'post_type' => 'page'
        ));

        foreach ($posts as $post) {
            $widgets = $this->getWidgetsForPost($post->ID);
        }
    }

    /**
     * Get widgets on a specific post sorted in sidebars
     * @param  int $postId
     * @return array
     */
    public function getWidgetsForPost(int $postId)
    {
        $sidebars = array_filter($this->getSidebarsForPost($postId));
        $retWidgets = array();

        foreach ($sidebars as $sidebar => $widgets) {
            $retWidgets[$sidebar] = array();

            foreach ($widgets as $widget) {
                $retWidgets[$sidebar][$widget] = $this->getWidget($postId, $widget);
                var_dump($retWidgets);
                exit;
            }
        }
    }

    /**
     * Get sidebar information for a specific post
     * @param  int    $postId
     * @return array
     */
    public function getSidebarsForPost(int $postId)
    {
        $sidebars = $this->fromDb->get_var($this->fromDb->prepare(
            "SELECT meta_value FROM wp_postmeta WHERE post_id = %d AND meta_key = %s",
            $postId,
            '_sidebars_widgets'
        ));

        return maybe_unserialize($sidebars);
    }

    /**
     * Gets a specific widget from a post
     * @param  int    $postId
     * @param  string $widgetIdString
     * @return array
     */
    public function getWidget(int $postId, string $widgetIdString)
    {
        $widgetIdParts = explode('-', $widgetIdString);
        $widgetId = end($widgetIdParts);
        $widgetType = str_replace('-' . $widgetId, '', $widgetIdString);

        $widgets = $this->fromDb->get_var($this->fromDb->prepare(
            "SELECT option_value FROM wp_options WHERE option_name = %s",
            'widget_' . $postId . '_' . $widgetType
        ));

        $widgets = maybe_unserialize($widgets);

        if (!isset($widgets[$widgetId])) {
            return false;
        }

        return $widgets[$widgetId];
    }
}

new \HbgMigrate\Migrate();
