<?php

namespace HbgMigrate;

class WidgetIndexBox extends \HbgMigrate\Widget
{
    public $widgetType = 'index_box';
    public $moduleType = 'mod-index';

    /**
     * Rebuilds widget to module and saves it
     * @param  array  $data
     * @return bool|int         int (post_id) if succes, else false
     */
    public function migrate(array $widgetData, int $postId)
    {
        $indexes = array();

        for ($i = 1; $i <= $widgetData['amount']; $i++) {
            // Skip non-published posts
            if (get_post_status($widgetData['item_id' . $i]) !== 'publish') {
                continue;
            }

            $indexes[$i] = array(
                'field_5743f66719b62' => 'internal', // link_type
                'field_569cf1252cfc9' => (int)$widgetData['item_id' . $i]
            );
        }

        // Bail if empty
        if (empty($news)) {
            return false;
        }

        $columns = 'grid-md-6';

        switch ($widgetData['widget_meta']['sidebar']) {
            case 'right-sidebar':
            case 'left-sidebar':
            case 'left-sidebar-bottom':
                $columns = 'grid-md-12';
                break;
        }

        $data = array(
            'post_title' => isset($widgetData['title']) ? $widgetData['title'] : '',
            'post_content' => '',
            'acf' => array(
                'field_569ceabc2cfc8' => $indexes,
                'field_56eab26cd3a86' => $columns
            )
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }
}

new \HbgMigrate\WidgetIndexBox();
