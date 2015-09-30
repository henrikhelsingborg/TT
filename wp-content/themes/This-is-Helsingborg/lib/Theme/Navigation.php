<?php

namespace Helsingborg\Theme;

class Navigation
{
    public function __construct()
    {
        self::registerMenus();

        add_action('post_updated', array($this, 'purgeTreeMenuTransient'), 10, 3);
    }

    /**
     * Register navigation menus
     * @return void
     */
    public static function registerMenus()
    {
        register_nav_menus(array(
            'main-menu' => 'Huvudmeny',
            'top-menu' => 'Toppmeny',
            'footer-menu' => 'Hjälpmeny'
        ));
    }

    /**
     * Find out which pages menus must be purged
     * @param  integer $postId The post id to empty for
     * @return void
     */
    public function purgeTreeMenuTransient($postId, $postAfter, $postBefore)
    {   
        // Compare post_parent, if changed we need to empty menu cahce on both the old and the new parent
        if ($postBefore->post_parent != $postAfter->post_parent) {
            $this->purgeTreeMenuTransientForAncestors($postBefore->post_parent);
        }
        
        $this->purgeTreeMenuTransientForAncestors($postId);
        
    }

    /**
     * Delete tree menu transient for ancestors of post id
     * @param  integer $postId The post id
     * @return
     */
    public function purgeTreeMenuTransientForAncestors($postId)
    {
        // Get page ancestors
        $ancestors = get_post_ancestors($postId);
        $ancestors[] = $postId;

        // Remove front page from ancestors array
        $ancestors = array_reverse($ancestors);
        if ($ancestors[0] == get_option('page_on_front')) unset($ancestors[0]);
        $ancestors = array_values($ancestors);

        // Delete transient for page ancestors
        // menu_mobile_<post_id>
        // menu_<post_id>
        foreach ($ancestors as $postId) {
            $children = get_children(array(
                'post_parent' => $postId,
                'numberofposts' => -1,
                'post_type' => 'page'
            ));

            foreach ($children as $child) {
                delete_transient('menu_mobile_' . $child->ID);
                delete_transient('menu_' . $child->ID);
            }
        }
    }
}