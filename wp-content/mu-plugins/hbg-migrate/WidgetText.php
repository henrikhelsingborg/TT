<?php

namespace HbgMigrate;

class WidgetText extends \HbgMigrate\Widget
{
    public $widgetType = 'text';
    public $moduleType = 'mod-text';

    /**
     * Rebuilds widget to module and saves it
     * @param  array  $data
     * @return bool|int         int (post_id) if succes, else false
     */
    public function migrate(array $widgetData, int $postId)
    {
        $data = array(
            'post_title' => $widgetData['title'],
            'post_content' => $widgetData['text']
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }
}

new \HbgMigrate\WidgetText();
