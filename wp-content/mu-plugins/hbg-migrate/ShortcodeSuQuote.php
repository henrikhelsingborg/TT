<?php

namespace HbgMigrate;

class ShortcodeSuQuote extends \HbgMigrate\Shortcode
{
    public $shortcode = 'su_quote';
    public $moduleType = false;

    public function migrate(\WP_Post $post, string $full, string $base, array $attributes = null, string $content = null)
    {
        $markup = '<blockquote>';
        $markup .= '<p>' . $content . '</p>';

        if (isset($attributes['cite'])) {
            $markup .= '<footer><cite>' . $attributes['cite'] . '</cite></footer>';
        }

        $markup .= '</blockquote>';

        $this->saveWithoutModule($post, $full, $markup);
    }
}

new \HbgMigrate\ShortcodeSuQuote();
