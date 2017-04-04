<?php

namespace HbgMigrate;

abstract class Template
{
    public $template;
    public $templateTo;

    public function __construct()
    {
        add_action('HbgMigrate/template/' . $this->template, array($this, 'migrate'), 10, 2);
    }

    /**
     * Absract migration method
     * @param  array  $data
     * @param  int    $postId
     * @return void
     */
    public function migrate(string $template, \WP_Post $post)
    {
        if (!empty($this->templateTo)) {
            update_post_meta($post->ID, '_wp_page_template', $this->templateTo);
        }
    }
}
