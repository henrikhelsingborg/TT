<?php

namespace HbgMigrate;

class WidgetSimpleLinkList extends \HbgMigrate\Widget
{
    public $widgetType = 'simplelinklistwidget';
    public $moduleType = 'mod-posts';

    /**
     * Rebuilds widget to module and saves it
     * @param  array  $data
     * @return bool|int         int (post_id) if succes, else false
     */
    public function migrate(array $widgetData, int $postId)
    {
        $items = array();

        for ($i = 1; $i <= $widgetData['amount']; $i++) {
            $items[$i] = array(
                'field_576258f4110b1' => $widgetData['item' . $i], // post_title
                'field_576261c3ef10e' => $widgetData['item_link' . $i] // post_title
            );
        }

        $data = array(
            'post_title' => '',
            'post_content' => '',
            'acf' => array(
                'field_571dfd4c0d9d9' => 'list', // posts_display_as
                'field_571e01e7f246c' => array('title'), // posts_fields
                'field_576258d3110b0' => 'input', // posts_data_source
                'field_571dfc6ff8115' => $items, // data
                'field_571dff4eb46c3' => -1, // posts_count
            )
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
        exit;
    }
}

new \HbgMigrate\WidgetSimpleLinkList();
