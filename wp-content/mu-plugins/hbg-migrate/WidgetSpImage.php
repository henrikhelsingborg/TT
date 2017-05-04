<?php

namespace HbgMigrate;

class WidgetSpImage extends \HbgMigrate\Widget
{
    public $widgetType = 'widget_sp_image';
    public $moduleType = 'mod-image';

    /**
     * Rebuilds widget to module and saves it
     * @param  array  $data
     * @return bool|int         int (post_id) if succes, else false
     */
    public function migrate(array $widgetData, int $postId)
    {
        if (!isset($widgetData['attachment_id'])) {
            return;
        }

        $data = array(
            'post_title' => isset($widgetData['title']) ? $widgetData['title'] : '',
            'post_content' => '',
            'acf' => array(
                'field_570770b8e2e61' => (int)$widgetData['attachment_id'], // Image
                'field_570770f5e2e62' => false, // Crop
                'field_570775955b8de' => true, // Responsive
                'field_5707716fabf17' => 'medium', // Image size
            )
        );

        // Description
        if (isset($widgetData['description'])) {
            $data['acf']['field_587604df2975f'] = $widgetData['description'];
        }

        // Link
        if (isset($widgetData['link'])) {
            $data['acf']['field_577d07c8d72db'] = 'external';
            $data['acf']['field_577d0810d72dc'] = $widgetData['link'];
        }

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }
}

new \HbgMigrate\WidgetSpImage();
