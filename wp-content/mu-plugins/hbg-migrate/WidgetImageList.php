<?php

namespace HbgMigrate;

class WidgetImageList extends \HbgMigrate\Widget
{
    public $widgetType = 'image_list_widget';
    public $moduleType = 'mod-slider';

    public function migrate(array $widgetData, int $postId)
    {
        if (!isset($widgetData['amount'])) {
            return;
        }

        $images = array();

        global $wpdbFrom, $wpdb;
        $table = "wp_posts";
        if (get_current_blog_id() > 1) {
            $table = "wp_" . get_current_blog_id() . "_posts";
        }

        for ($i = 1; $i <= $widgetData['amount']; $i++) {
            $imageId = $wpdbFrom->get_var("SELECT ID FROM $table WHERE guid = '" . $widgetData['imageurl' . $i] . "'");

            // Initial slide data
            $images[$i] = array(
                'acf_fc_layout' => 'image',
                'field_56a5ed2f398dc' => intval($imageId), // image
                'field_570f4e9b10c26' => intval($imageId) // mobile_image
            );

            // Text
            if (!empty($widgetData['item_text' . $i])) {
                $images[$i]['field_56ab224ac2c28'] = 1;
                $images[$i]['field_56e7fa620ee0a'] = 'bottom';
                $images[$i]['field_56ab235393f04'] = $widgetData['item_text' . $i];
            }

            // Link
            $images[$i]['field_56fa87ec3ace2'] = 'false';
            if (!empty($widgetData['item_link' . $i])) {
                $images[$i]['field_56fa87ec3ace2'] = 'external'; // link_type
                $images[$i]['field_56fa87fa3ace4'] = $widgetData['item_link' . $i]; // link_url
                $images[$i]['field_56fa880c3ace6'] = $widgetData['item_target' . $i]; // link_target
            }
        }

        $data = array(
            'post_title' => $widgetData['title'],
            'post_content' => '',
            'acf' => array(
                'field_573dce058a66t' => 'default', // slider_layout
                'field_573dce058a66e' => 'ratio-16-9', // slider_format
                'field_58934110b566f' => '1', // slider_columns
                'field_58934110b566e' => 'center', // slide_align
                'field_5731c6d886811' => '0', // slides_autoslide
                'field_573d8880abc96' => 'center', // navigation_position
                'field_58933fb6f5ed4' => array('wrapAround', 'pageDots'), // additional_options
                'field_56a5e994398d6' => $images // slides
            )
        );

        $this->save($data, $postId, $widgetData['widget_meta']['widget_id'], $widgetData['widget_meta']['sidebar']);
    }
}

new \HbgMigrate\WidgetImageList();
