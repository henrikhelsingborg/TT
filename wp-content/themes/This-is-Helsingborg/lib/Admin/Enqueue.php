<?php

namespace Helsingborg\Admin;

class Enqueue
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', '\Helsingborg\Admin\Enqueue::dequeueScripts');
        add_action('admin_enqueue_scripts', '\Helsingborg\Admin\Enqueue::enqueueScripts');
    }

    /**
     * Dequeues scripts
     * @return void
     */
    public static function dequeueScripts()
    {

    }

    /**
     * Enqueue scripts
     * @return void
     */
    public static function enqueueScripts()
    {
        wp_register_style(
            'custom_wp_admin_css',
            get_template_directory_uri() . '/assets/css/dist/admin.min.css',
            array(),
            '1.0.0'
        );
        wp_enqueue_style('custom_wp_admin_css');

        wp_register_script(
            'jquery-ui',
            get_template_directory_uri() . '/assets/js/dist/jquery-ui.min.js',
            array(),
            '1.0.0',
            false
        );

        wp_register_script(
            'custom-admin',
            get_template_directory_uri() . '/assets/js/dist/admin.min.js',
            array(),
            '1.0.0',
            false
        );

        wp_enqueue_script('jquery-ui');
        wp_enqueue_script('custom-admin');
    }
}
