<?php

namespace HbgInherit\CustomPostType;

class Contact
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
            'name'               => _x('Kontaktuppgifter', 'post type name'),
            'singular_name'      => _x('Kontaktuppgift', 'post type singular name'),
            'menu_name'          => __('Kontaktuppgifter'),
            'add_new'            => __('Lägg till nya kontaktuppgifter'),
            'add_new_item'       => __('Lägg till kontaktuppgifter'),
            'edit_item'          => __('Redigera kontaktuppgifter'),
            'new_item'           => __('Ny kontaktuppgift'),
            'all_items'          => __('Kontaktuppgifter'),
            'view_item'          => __('Visa kontaktuppgifter'),
            'search_items'       => __('Sök kontaktuppgifter'),
            'not_found'          => __('Inga kontaktuppgifter att visa'),
            'not_found_in_trash' => __('Inga kontaktuppgifter i papperskorgen')
        );

        $args = array(
            'labels'               => $labels,
            'description'          => 'Inherit contet of type "contact"',
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
            'supports'             => array('title', 'revisions')
        );

        register_post_type('hbgInheritContact', $args);
    }
}
