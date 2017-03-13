<?php

namespace HbgMigrate;

class WidgetNewsListBox extends \HbgMigrate\Widget
{
    public $widgetType = 'news_list_box';
    public $moduleType = 'mod-posts';

    /**
     * Rebuilds widget to module and saves it
     * @param  array  $data
     * @return bool|int         int (post_id) if succes, else false
     */
    public function migrate(array $widgetData, int $postId)
    {
        $news = array();

        for ($i = 1; $i <= $widgetData['amount']; $i++) {
            $news[] = (int)$widgetData['item_id' . $i];
        }

        $data = array(
            'post_title' => '',
            'post_content' => '',
            'acf' => array(
                'field_571dfd4c0d9d9' => 'list', // posts_display_as
                'field_571e01e7f246c' => array('date', 'title'), // posts_fields
                'field_571dfaafe6984' => 'manual', // posts_data_source
                'field_571dfc6ff8115' => $news, // posts_data_posts
                'field_571dff4eb46c3' => -1, // posts_count
                'field_571dffca1d90b' => 'date', // posts_sort_by
                'field_571e00241d90c' => 'desc' // posts_sort_order
            )
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
        exit;
    }
}

new \HbgMigrate\WidgetNewsListBox();
