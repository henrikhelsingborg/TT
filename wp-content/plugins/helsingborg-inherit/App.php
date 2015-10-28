<?php

namespace HbgInherit;

class App
{
    public function __construct()
    {
        add_action('init', array($this, 'addParentOptionsPage'));

        new CustomPostType\Text;
        new CustomPostType\OpeningHours;
        new CustomPostType\Contact;

        // Widget
        add_action('widgets_init', function () {
            register_widget('\HbgInherit\Widget\InheritContent');
        });

        //register_deactivation_hook(EVALUATE_PATH . '/evaluate.php', array($this, 'flushRewriteRules'));
        //register_activation_hook(EVALUATE_PATH . '/evaluate.php', array($this, 'flushRewriteRules'));
    }

    /**
     * Registers the option page holing the "Inherit" custom post types
     */
    public function addParentOptionsPage()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title' => 'Arvsinnehåll',
                'menu_slug'  => 'hbg-inherit',
                'capability' => 'edit_posts',
                'icon_url' => 'dashicons-controls-repeat',
                'position' => '30.2'
            ));
        }
    }
}
