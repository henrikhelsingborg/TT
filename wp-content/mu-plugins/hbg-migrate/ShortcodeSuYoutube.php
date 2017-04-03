<?php

namespace HbgMigrate;

class ShortcodeSuYoutube extends \HbgMigrate\Shortcode
{
    public $shortcode = 'su_youtube';

    public function migrate(\WP_Post $post, string $full, string $base, array $attributes = null, string $content = null)
    {
        $this->saveWithoutModule($post, $full, $attributes['url']);
    }
}

new \HbgMigrate\ShortcodeSuYoutube();
