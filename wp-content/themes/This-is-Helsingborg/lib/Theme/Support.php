<?php

namespace Helsingborg\Theme;

class Support
{
    public function __construct()
    {
        self::removeActions();
        self::addActions();
        self::addFilters();
        self::removeTheGenerator();

        add_filter('srm_max_redirects', array($this, 'dbx_srm_max_redirects'));
        add_action('template_redirect', array($this, 'blockAuthorPages'), 5);
    }

    /**
     * Removes unwanted actions
     * @return void
     */
    static private function removeActions()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
    }

    /**
     * Add actions
     */
    static private function addActions()
    {
        add_action('after_setup_theme', '\Helsingborg\Theme\Support::themeSupport');
    }

    /**
     * Add filters
     */
    static private function addFilters()
    {
        add_filter('intermediate_image_sizes_advanced', '\Helsingborg\Theme\Support::filterThumbnailSizes');
        add_filter('gettext', '\Helsingborg\Theme\Support::changeDefaultTemplateName', 10, 3);
    }

    /**
     * Add theme support
     * @return void
     */
    public static function themeSupport()
    {
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array(
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat')
        );
    }

    /**
     * Remove medium thumbnail size for all uploaded images
     * @param  array $sizes Default sizes
     * @return array        New sizes
     */
    public static function filterThumbnailSizes($sizes)
    {
        unset($sizes['medium']);
        return $sizes;
    }

    /**
     * Change "Default template" to "Article"
     */
    public static function changeDefaultTemplateName($translation, $text, $domain)
    {
        if ($text == 'Default Template') {
            return _('Artikel');
        }

        return $translation;
    }

    /**
     * Removes the generator meta tag from <head>
     * @return void
     */
    public static function removeTheGenerator()
    {
        add_filter('the_generator', create_function('', 'return "";'));
    }

    /**
     * Blocks request to the author pages (?author=<ID>)
     * @return [type] [description]
     */
    public function blockAuthorPages() {
        global $wp_query;
    
        if (is_author() || is_attachment()) {
            $wp_query->set_404();
        }
    
        if (is_feed()) {
            $author     = get_query_var('author_name');
            $attachment = get_query_var('attachment');
            $attachment = (empty($attachment)) ? get_query_var('attachment_id') : $attachment;
    
            if (!empty($author) || !empty($attachment)) {
                $wp_query->set_404();
                $wp_query->is_feed = false;
            }
        }
    }

    /**
     * Update the default maximum number of redirects to 400
     * @return void
     */
    public function dbx_srm_max_redirects() {
        return 400;
    }
}