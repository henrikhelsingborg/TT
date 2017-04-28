<?php

namespace HbgMigrate;

class WidgetIndexLargeBox extends \HbgMigrate\Widget
{
    public $widgetType = 'index_large_box';
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
            // Skip non-published posts
            if (get_post_status($widgetData['item_id' . $i]) !== 'publish') {
                continue;
            }

            $news[] = (int)$widgetData['item_id' . $i];
        }

        // Bail if empty
        if (empty($news)) {
            return false;
        }

        $columns = 'grid-md-4';

        switch ($widgetData['widget_meta']['sidebar']) {
            case 'right-sidebar':
            case 'left-sidebar':
            case 'left-sidebar-bottom':
                $columns = 'grid-md-12';
                break;
        }

        $data = array(
            'post_title' => '',
            'post_content' => '',
            'acf' => array(
                'field_571dfd4c0d9d9' => 'items', // posts_display_as
                'field_571dfdf50d9da' => $columns, // posts_columns
                'field_571e01e7f246c' => array('title', 'image'), // posts_fields
                'field_571dfaafe6984' => 'manual', // posts_data_source
                'field_571dfc6ff8115' => $news, // posts_data_posts
                'field_571dff4eb46c3' => -1, // posts_count
                'field_571dffca1d90b' => 'date', // posts_sort_by
                'field_571e00241d90c' => 'desc' // posts_sort_order
            )
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }
}

new \HbgMigrate\WidgetIndexLargeBox();
