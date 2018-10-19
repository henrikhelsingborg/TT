<?php

/*
Plugin Name: Add Algolia attribute
Description: Adds custom attributes to algolia search index.
Version:     1.0
Author:      Sebastian Thulin, Helsingborg Stad
*/
class AddAlgoliaAttribute
{
    /**
     * Init on algolia hooks
     */
    public function __construct()
    {
        add_filter('algolia_post_shared_attributes', array($this, 'addLevel'), 10, 2);
        add_filter('algolia_searchable_post_shared_attributes', array($this, 'addLevel'), 10, 2);
    }

    /**
     * Add a attribute to algolia search
     *
     * @param array   $attributes Previously added attrbutes
     * @param WP_Post $post       The post object
     *
     * @return array
     */
    public function addLevel($attributes, $post)
    {

        $numberOfLevels = (substr_count(get_permalink($post), "/")-3);

        if ($numberOfLevels != 0) {
            $attributes['post_level_importance'] = $numberOfLevels;
        } else {
            $attributes['post_level_importance'] = 5;
        }
        return $attributes;
    }

}

new AddAlgoliaAttribute();
