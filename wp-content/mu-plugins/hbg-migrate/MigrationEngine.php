<?php

namespace HbgMigrate;

class MigrationEngine
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

        $this->start(0, 500);
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
            'post_type' => 'page',
            'post_status' => 'publish'
        ));

        echo "<strong>START</strong><br>";

        foreach ($posts as $post) {
            $this->migrateWidgetsForPost($post->ID);
        }

        echo "<strong>END</strong>";
    }

    /**
     * Run migration actions for widget from post
     * @param  int    $postId
     * @return void
     */
    public function migrateWidgetsForPost(int $postId)
    {
        $widgets = $this->getWidgetsForPost($postId);

        foreach ($widgets as $widget) {
            // HbgMigrate/{widget_type}
            do_action('HbgMigrate/' . $widget['widget_meta']['type'], $widget, $postId);

            // HbgMigrate/{widget_id}
            do_action('HbgMigrate/' . $widget['widget_meta']['widget_id'], $widget, $postId);
        }
    }

    /**
     * Get widgets on a specific post sorted in sidebars
     * @param  int $postId
     * @return array
     */
    public function getWidgetsForPost(int $postId) : array
    {
        $sidebars = array_filter($this->getSidebarsForPost($postId));
        $retWidgets = array();

        foreach ($sidebars as $sidebar => $widgets) {
            if (!is_array($widgets) || empty($widgets)) {
                continue;
            }

            foreach ($widgets as $key => $widget) {
                $widgetData = $this->getWidget($postId, $widget);
                $widgetData['widget_meta']['type'] = $this->getWidgetType($widget);
                $widgetData['widget_meta']['sidebar'] = $sidebar;
                $widgetData['widget_meta']['widget_id'] = $widget;
                $widgetData['widget_meta']['post_id'] = $postId;
                $retWidgets[] = $widgetData;
            }
        }

        return $retWidgets;
    }

    /**
     * Get sidebar information for a specific post
     * @param  int    $postId
     * @return array
     */
    public function getSidebarsForPost(int $postId) : array
    {
        $sidebars = $this->fromDb->get_var($this->fromDb->prepare(
            "SELECT meta_value FROM wp_postmeta WHERE post_id = %d AND meta_key = %s",
            $postId,
            '_sidebars_widgets'
        ));

        $sidebars = maybe_unserialize($sidebars);

        if (is_null($sidebars) || !is_array($sidebars)) {
            return array();
        }

        if (isset($sidebars['array_version'])) {
            unset($sidebars['array_version']);
        }

        return $sidebars;
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

    /**
     * Get widget type as slug
     * @param  string $widgetIdentifier Widget identifier
     * @return string                   Widget type
     */
    public function getWidgetType(string $widgetIdentifier) : string
    {
        $widgetIdParts = explode('-', $widgetIdentifier);
        $widgetId = end($widgetIdParts);
        $widgetType = str_replace('-' . $widgetId, '', $widgetIdentifier);

        return $widgetType;
    }
}
