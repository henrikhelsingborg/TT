<?php

namespace HbgMigrate;

class MigrationEngine
{
    public $postType;

    protected $activeDb = 'to';

    protected $fromDb;
    protected $toDb;

    protected $failed = array();

    protected $shortcodes = array();

    public function __construct($start = true)
    {
        global $wpdb, $wpdbFrom;

        $this->toDb = $wpdb;
        $this->fromDb = $wpdbFrom;


        if ($start) {
            $this->start(0, -1);
        }
    }

    public static function getTable($table = 'posts')
    {
        $prefix = 'wp_';

        if (isset($_GET['site_id']) && !empty($_GET['site_id'])) {
            $prefix .= $_GET['site_id'] . '_';
        }

        return $prefix . $table;
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

        if (empty($posts)) {
            echo "NO POSTS";
            return;
        }

        echo "<strong>START</strong><br>";

        foreach ($posts as $post) {
            $this->migrateWidgetsForPost($post->ID);
            $this->migrateShortcodesForPost($post);
            $this->migrateTemplateForPost($post);
        }

        echo "<strong>END</strong>";
    }

    /**
     * Run migration actions for widget from post
     * @param  int    $postId
     * @return void
     */
    public function migrateTemplateForPost(\WP_Post $post)
    {
        $template = get_post_meta($post->ID, '_wp_page_template', true);

        if ($template && $template !== 'default') {
            do_action('HbgMigrate/template/' . basename($template), $template, $post);
        }
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
            do_action('HbgMigrate/widget/' . $widget['widget_meta']['type'], $widget, $postId);

            // HbgMigrate/{widget_id}
            do_action('HbgMigrate/widget/' . $widget['widget_meta']['widget_id'], $widget, $postId);
        }
    }

    /**
     * Migration proccess for shortcodes
     * @param  \WP_Post $post
     * @return void
     */
    public function migrateShortcodesForPost(\WP_Post $post)
    {
        preg_match_all('/\[(.+?)?\](?:(.+?)?\[\/(.+?)\])?/i', $post->post_content, $matches);
        $matches = array_filter($matches);

        // $matches[0] = full
        // $matches[1] = {shortcode} {attributes}
        // $matches[2] = content
        // $matches[3] = end tag

        if (empty($matches)) {
            return;
        }

        if (isset($_GET['list_shortcodes']) && $_GET['list_shortcodes'] === 'true') {
            echo $matches[1][0] . ' (<a href="' . get_edit_post_link($post->ID) . '">' . $post->ID . '</a>)<br>';
            return;
        }

        for ($i = 0; $i < count($matches[0]); $i++) {
            $attributes = array();

            if (isset(explode(' ', $matches[1][$i], 2)[1])) {
                $htmlAttributes = preg_split('/\s+(?=([^"]*"[^"]*")*[^"]*$)/i',explode(' ', $matches[1][$i], 2)[1]);

                foreach ($htmlAttributes as &$attribute) {
                    $attribute = explode('=', $attribute, 2);

                    if (count($attribute) == 2) {
                        $attributes[$attribute[0]] = str_replace('"', '', $attribute[1]);
                    } else {
                        $attributes[] = $attribute;
                    }
                }
            }

            $shortcodeData = array(
                'full' => $matches[0][$i],
                'shortcode' => explode(' ', $matches[1][$i], 2)[0],
                'attributes' => $attributes,
                'content' => $matches[2][$i]
            );

            do_action('HbgMigrate/shortcode/' . $shortcodeData['shortcode'], $post, $shortcodeData['full'], $shortcodeData['shortcode'], $shortcodeData['attributes'], $shortcodeData['content']);
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

        if (isset($sidebars['wp_inactive_widgets'])) {
            unset($sidebars['wp_inactive_widgets']);
        }

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
            "SELECT meta_value FROM " . self::getTable('postmeta') . " WHERE post_id = %d AND meta_key = %s",
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
            "SELECT option_value FROM " . self::getTable('options') .  " WHERE option_name = %s",
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

    /**
     * View structure for random widget of type
     * @param  string $widgetType Widget type
     * @return array
     */
    public function getWidgetStructure($widgetType)
    {
        $data = $this->fromDb->get_results($this->fromDb->prepare(
            "SELECT option_value FROM " . self::getTable('options') . " WHERE (option_name REGEXP %s) ORDER BY RAND() LIMIT 1",
            '^widget_([0-9]+)_' . $widgetType
        ));

        $values = maybe_unserialize($data[0]->option_value);
        $values = array_values($values);

        return $values[0];
    }

    /**
     * Gets all types of widgets from the database
     * @return array
     */
    public function getWidgetTypes() : array
    {
        $data = $this->fromDb->get_results($this->fromDb->prepare(
            "SELECT * FROM " . self::getTable('options') . " WHERE (option_name REGEXP %s)",
            '^widget_([0-9]+)_(.*)'
        ));

        $types = array();

        foreach ($data as $item) {
            preg_match_all('/^widget_([0-9]+)_(.*)/i', $item->option_name, $matches);
            if (!isset($matches[2][0])) {
                continue;
            }

            $types[] = $matches[2][0];
        }

        $types = array_values(array_unique($types));
        return $types;
    }
}
