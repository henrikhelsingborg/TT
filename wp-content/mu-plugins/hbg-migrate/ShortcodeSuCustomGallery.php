<?php

namespace HbgMigrate;

class ShortcodeSuCustomGallery extends \HbgMigrate\Shortcode
{
    public $shortcode = 'su_custom_gallery';
    public $moduleType = 'mod-slider';

    public function migrate(\WP_Post $post, string $full, string $base, array $attributes = null, string $content = null)
    {
        $source = $attributes['source'];
        $source = explode(':', $source);

        if (!isset($source[0]) || $source[0] !== 'media') {
            return;
        }

        $sourceImages = explode(',', $source[1]);
        $sourceImages = array_map('trim', $sourceImages);

        $images = array();

        foreach ($sourceImages as $image) {
            $images[] = array(
                'acf_fc_layout' => 'image',
                'field_56a5ed2f398dc' => (int) $image, // image
                'field_570f4e9b10c26' => (int) $image // mobile_image
            );
        }

        $data = array(
            'post_title' => '',
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

        $this->save($data, $post, $full);
    }
}

new \HbgMigrate\ShortcodeSuCustomGallery();
