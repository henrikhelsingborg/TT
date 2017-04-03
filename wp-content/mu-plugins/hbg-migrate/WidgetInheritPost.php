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
        if (!isset($widgetData['post_id'])) {
            return;
        }

        global $wpdbFrom;
        $post = $wpdbFrom->get_row("SELECT post_title, post_content FROM " . \HbgMigrate\MigrationEngine::getTable('posts') . " WHERE ID = " . $widgetData['post_id']);

        if (empty($post)) {
            return;
        }

        $data = array(
            'post_title' => isset($widgetData['title']) ? $widgetData['title'] : '',
            'post_content' => $post->post_content
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar'], $post->post_title . ' (migrated)');
    }
}

new \HbgMigrate\WidetInheritPost();
