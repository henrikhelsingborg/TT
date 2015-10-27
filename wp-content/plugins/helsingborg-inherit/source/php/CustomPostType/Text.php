<?php

namespace HbgInherit\CustomPostType;

class Text
{
    public function __construct()
    {
        // Register the post type
        add_action('init', array($this, 'registerPostType'));
    }

    /**
     * Registers the custom post type
     * @return void
     */
    public function registerPostType()
    {
        $labels = array(
            'name'               => _x('Textinnehåll', 'post type name'),
            'singular_name'      => _x('Textinnehåll', 'post type singular name'),
            'menu_name'          => __('Text'),
            'add_new'            => __('Lägg till nytt textinnehåll'),
            'add_new_item'       => __('Lägg till textinnehåll'),
            'edit_item'          => __('Redigera textinnehåll'),
            'new_item'           => __('Nytt textinnehåll'),
            'all_items'          => __('Textinnehåll'),
            'view_item'          => __('Visa textinnehåll'),
            'search_items'       => __('Sök textinnehåll'),
            'not_found'          => __('Inget textinnehåll att visa'),
            'not_found_in_trash' => __('Inget textinnehåll i papperskorgen')
        );

        $args = array(
            'labels'               => $labels,
            'description'          => 'Inherit contet of type "text"',
            'has_archive'          => true,
            'menu_icon'            => 'dashicons-controls-repeat',
            'show_in_menu'         => 'hbg-inherit',
            'public'               => false,
            'publicly_queriable'   => true,
            'show_ui'              => true,
            'show_in_nav_menus'    => true,
            'has_archive'          => true,
            'rewrite'              => false,
            'exclude_from_search'  => true,
            'supports'             => array('title', 'editor', 'revisions')
        );

        register_post_type('hbgInheristPosts', $args);
    }
}
