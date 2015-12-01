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
     * Register navigation menus.
     */
    public static function registerMenus()
    {
        register_nav_menus(array(
            'main-menu' => 'Huvudmeny',
            'top-menu' => 'Toppmeny',
            'top-menu-help' => 'Toppmeny Hjälp',
            'footer-menu' => 'Footer meny',
        ));
    }

    /**
     * Find out which pages menus must be purged.
     * @param int $postId The post id to empty for
     */
    public function purgeTreeMenuTransient($postId, $postAfter, $postBefore)
    {
        $pb = $postBefore;
        $pa = $postAfter;

        unset($pb->post_modified, $pb->post_modified_gmt, $pa->post_modified, $pa->post_modified_gmt);

        // Compare post_parent, if changed we need to empty menu cahce on both the old and the new parent
        if ($pb != $pa) {
            $this->purgeTreeMenuTransientForAncestors($postBefore->post_parent);
        }
    }

    /**
     * Delete tree menu transient for ancestors of post id.
     * @param int $postId The post id
     * @return
     */
    public function purgeTreeMenuTransientForAncestors($postId)
    {
        // Get page ancestors
        $ancestors = get_post_ancestors($postId);
        $ancestors[] = $postId;

        // Remove front page from ancestors array
        $ancestors = array_reverse($ancestors);
        if ($ancestors[0] == get_option('page_on_front')) {
            unset($ancestors[0]);
        }
        $ancestors = array_values($ancestors);

        // Delete transient for page ancestors
        // menu_mobile_<post_id>
        // menu_<post_id>
        foreach ($ancestors as $postId) {
            $children = get_children(array(
                'post_parent' => $postId,
                'numberofposts' => -1,
                'post_type' => 'page',
            ));

            foreach ($children as $child) {
                delete_transient('menu_mobile_'.$child->ID);
                delete_transient('menu_'.$child->ID);

                // Empty W3 Total Cache
                if (function_exists('\WpSimpleCachePlugin\Cache\WpSimpleCache_purge_post_by_id')) {
                    \WpSimpleCachePlugin\Cache\WpSimpleCache_purge_post_by_id($postId);
                }
            }
        }
    }
}
