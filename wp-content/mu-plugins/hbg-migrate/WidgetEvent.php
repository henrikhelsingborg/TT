<?php

namespace HbgMigrate;

class WidgetEvent extends \HbgMigrate\Widget
{
    public $widgetType = 'eventlistwidget';
    public $moduleType = 'mod-event';

    /**
     * Rebuilds widget to module and saves it
     * @param  array  $data
     * @return bool|int         int (post_id) if succes, else false
     */
    public function migrate(array $widgetData, int $postId)
    {
        $data = array(
            'post_title' => isset($widgetData['title']) ? $widgetData['title'] : '',
            'post_content' => '',
            'acf' => array(
                'field_583fe58262287' => $widgetData['amount'], // Events to show
                'field_58e6370d4f34c' => 1, // Show archive link
                'field_583ffd8d10925' => 30, // Show 30 days of events from today
                'field_583fefb6634a1' => array('occasion'), // FIelds to disaply
                'field_586cf5c8d3686' => 1, // show groups
                'field_58de5b2d62d45' => 'left', // occasion positiion
                'field_58458b20dde03' => 1, // show tags
                'field_58455b0e93178' => 1, // show categories
            )
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }
}

new \HbgMigrate\WidgetEvent();
