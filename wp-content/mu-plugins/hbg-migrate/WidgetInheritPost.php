<?php

namespace HbgMigrate;

class WidetInheritPost extends \HbgMigrate\Widget
{
    public $widgetType = 'helsingborgpostinheritwidget';
    public $moduleType = 'mod-text';

    /**
     * Rebuilds widget to module and saves it
     * @param  array  $data
     * @return bool|int         int (post_id) if succes, else false
     */
    public function migrate(array $widgetData, int $postId)
    {
        global $wpdbFrom;
        $postContent = $wpdbFrom->get_var("SELECT post_content FROM wp_posts WHERE ID = " . $widgetData['post_id']);

        $data = array(
            'post_title' => isset($widgetData['title']) ? $widgetData['title'] : '',
            'post_content' => $postContent
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }
}

new \HbgMigrate\WidetInheritPost();
