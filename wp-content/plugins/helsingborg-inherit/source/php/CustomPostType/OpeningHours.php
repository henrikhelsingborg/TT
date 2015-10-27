<?php

namespace HbgInherit\CustomPostType;

class OpeningHours
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
            'name'               => _x('Öppettider', 'post type name'),
            'singular_name'      => _x('Öppettider', 'post type singular name'),
            'menu_name'          => __('Öppettider'),
            'add_new'            => __('Lägg till nya öppettider'),
            'add_new_item'       => __('Lägg till öppettider'),
            'edit_item'          => __('Redigera öppettider'),
            'new_item'           => __('Nya öppettider'),
            'all_items'          => __('Öppettider'),
            'view_item'          => __('Visa öppettider'),
            'search_items'       => __('Sök öppettider'),
            'not_found'          => __('Inga öppettider att visa'),
            'not_found_in_trash' => __('Inga öppettider i papperskorgen')
        );

        $args = array(
            'labels'               => $labels,
            'description'          => 'Inherit contet of type "opening hours"',
            'menu_position'        => 100,
            'has_archive'          => true,
            'show_in_menu'         => 'hbg-inherit',
            'public'               => false,
            'publicly_queriable'   => true,
            'show_ui'              => true,
            'show_in_nav_menus'    => true,
            'has_archive'          => true,
            'rewrite'              => false,
            'exclude_from_search'  => true,
            'supports'             => array('title', 'revisions', 'editor')
        );

        register_post_type('hbgInheritHours', $args);
    }
}
