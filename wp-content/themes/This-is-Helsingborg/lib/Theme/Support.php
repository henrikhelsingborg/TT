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

        add_filter('srm_max_redirects', array($this, 'srmMaxRedirects'));
        add_action('template_redirect', array($this, 'blockAuthorPages'), 5);
        add_action('init', array($this, 'removePostPostType'), 11);
        
        //Theme functions 
        if ((defined("WP_ENABLE_THEME_SETTINGS") && WP_ENABLE_THEME_SETTINGS === true)) {
	        add_action('init', array($this, 'themeFunctionsAdminPanel'), 11);
	        
	        add_action('init', array($this, 'themeSettingsAdminPanel'), 11);
	    }
	    
    }
    
    /* Manage avabile functions in site - What modules should we use? */ 
    public function themeFunctionsAdminPanel () {
	   
	    if( function_exists('acf_add_options_page') ) {
			
			acf_add_options_page(array(
				'page_title' 	=> __("Theme Functions",'helsingborg'),
				'menu_title' 	=> __("Theme Functions",'helsingborg'),
				'menu_slug' 	=> __("Theme Functions",'helsingborg'),
				'capability' 	=> 'read',
				'redirect' 		=> false
			));
			
			if ( !class_exists('Disable_Comments') ) {
				
				if ( is_super_admin() ) { //Todo: Only show if told to inacive comments. 
				
					add_action( 'admin_notices', function(){
						echo '<div class="updated"><p>'; 
							_e( 'Some functions in this theme requires: "Disable Comments Plugin".', 'helsingborg' );
						echo '</p></div>'; 
					});
				
				}
									
			} 
		
		} else {
			
			if ( is_super_admin() ) { 
			
				add_action( 'admin_notices', function(){
					echo '<div class="updated"><p>'; 
						_e( 'Some functions in this theme requires: "Advanced Custom Fields PRO".', 'helsingborg' );
					echo '</p></div>'; 
				});
			
			}
			
		}
		
    }
    
    /* Use data from module above - Create settings menu */ 
    public function themeSettingsAdminPanel() {
	    
	    //Generellt 
	    //Blogg
	    //Kommentarer 
	    //Färger
	    //Nyhetsflöde 
	    //Sidhuvud - Ändra logotype och välja om meny ska visas. Välja om hero ska synas (denna bör ändras på start). 
	    //Sökfunktion 
	    //Sidfot - Dynamiskt innehåll i form av repeterande fält (med listfunktion text och annat)
	    //Inbyggd seo 
	    //Arvsinnehåll? Om detta ligger i temat. 
    }

    /**
     * Removes the post type "post"
     * @return boolean
     */
    public function removePostPostType()
    {
        global $wp_post_types;

        if (isset($wp_post_types['post'])) {
            if (!defined("WP_ENABLE_POSTS") || (defined("WP_ENABLE_POSTS") && WP_ENABLE_POSTS !== true)) {
                unset($wp_post_types['post']);
                add_action('admin_menu', function () {
                    remove_menu_page('edit.php');
                });
            }

            return true;
        }

        return false;
    }

    /**
     * Removes unwanted actions.
     */
    private static function removeActions()
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
    }

    /**
     * Add actions.
     */
    private static function addActions()
    {
        add_action('after_setup_theme', '\Helsingborg\Theme\Support::themeSupport');
    }

    /**
     * Add filters.
     */
    private static function addFilters()
    {
        add_filter('intermediate_image_sizes_advanced', '\Helsingborg\Theme\Support::filterThumbnailSizes');
        add_filter('gettext', '\Helsingborg\Theme\Support::changeDefaultTemplateName', 10, 3);
    }

    /**
     * Add theme support.
     */
    public static function themeSupport()
    {
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'post-formats',
            array(
                'aside',
                'gallery',
                'link',
                'image',
                'quote',
                'status',
                'video',
                'audio',
                'chat'
            )
        );
    }

    /**
     * Remove medium thumbnail size for all uploaded images.
     * @param array $sizes Default sizes
     * @return array New sizes
     */
    public static function filterThumbnailSizes($sizes)
    {
        unset($sizes['medium']);

        return $sizes;
    }

    /**
     * Change "Default template" to "Article".
     */
    public static function changeDefaultTemplateName($translation, $text, $domain)
    {
        if ($text == 'Default Template') {
            return _('Artikel');
        }

        return $translation;
    }

    /**
     * Removes the generator meta tag from <head>.
     */
    public static function removeTheGenerator()
    {
        add_filter('the_generator', create_function('', 'return "";'));
    }

    /**
     * Blocks request to the author pages (?author=<ID>).
     * @return void
     */
    public function blockAuthorPages()
    {
        global $wp_query;

        if (is_author() || is_attachment()) {
            $wp_query->set_404();
        }

        if (is_feed()) {
            $author = get_query_var('author_name');
            $attachment = get_query_var('attachment');
            $attachment = (empty($attachment)) ? get_query_var('attachment_id') : $attachment;

            if (!empty($author) || !empty($attachment)) {
                $wp_query->set_404();
                $wp_query->is_feed = false;
            }
        }
    }

    /**
     * Update the default maximum number of redirects to 400.
     */
    public function srmMaxRedirects()
    {
        return 400;
    }
}
