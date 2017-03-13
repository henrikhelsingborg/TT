<?php

namespace HbgMigrate;

class WidgetIndexLargeBox extends \HbgMigrate\Widget
{
    public $widgetType = 'index_large_box';
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
            $indexes[$i] = array(
                'field_5743f66719b62' => 'internal', // link_type
                'field_569cf1252cfc9' => (int) $widgetData['item_id' . $i]
            );
        }

        $data = array(
            'post_title' => '',
            'post_content' => '',
            'acf' => array(
                'field_569ceabc2cfc8' => $indexes
            )
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }
}

new \HbgMigrate\WidgetIndexLargeBox();
