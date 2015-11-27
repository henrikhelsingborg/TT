<?php

namespace WpSimpleCachePlugin\Cache;

/*
Plugin Name: Simple File Cache for WordPress
Plugin URI:  http://sebastianthulin.se/simple-cache/
Description: A Simple and Effective File-cache for WordPress.
Author:      Sebastian Thulin & Kristoffer Svanmark @ Helsingborg Stad
Disable:	 To disable this plugin add define("WP_SIMPLE_CACHE_DISABLED", true); to configuration. 
*/

/* Store callback */ //TODO: FIX THIS
if ( !function_exists( 'wp_simple_cache_plugin_end' ) ) { 
	function wp_simple_cache_plugin_end ( $data ) {
	
		//Cache data
		$cache_instance = new WpSimpleCache();
		$cache_instance::store_cache($data);
	
		//Return to output
		return $data;
	
	}
}

global $wp_simple_cache;

if ( !class_exists( 'WpSimpleCache' ) ) { 

	Class WpSimpleCache {
		
		private static $file_hash;
		private static $domain_name;
		private static $cache_time;
		private static $cache_folder;
		
		private static $file_chmod; 
		private static $dir_chmod; 
	
		private static $blocked_urls;
		
		private static $post_request_checksum; 
	
		public function __construct() {
	
			//Setup variables
			self::$file_hash 		= md5(rtrim(trim(strtolower($_SERVER['REQUEST_URI'])),"/"));
			self::$domain_name 		= md5($_SERVER['SERVER_NAME']);
			self::$cache_folder		= "/cache/";
			
			//Cache time 
			if ( defined('DOING_AJAX') && DOING_AJAX === true ) {
				self::$cache_time 				= 300; 									//Cachetime in seconds for ajax calls (default 10 minutes)
				self::$post_request_checksum 	= "ajax_".md5(serialize($_POST));		//Filename for POST REQUEST
			} else {
				self::$cache_time 				= 60*60*24*30; 							//Global cachetime in seconds (default one month)
				self::$post_request_checksum 	= false; 								//Turn of post requests cache 
			}
			
			//What user mode? 
			self::$file_chmod 		= 0775; 
			self::$dir_chmod		= 0775; 
	
			//What urls should not be cached?
			self::$blocked_urls		= array("wp-admin","wp-login","secure");
	
			//Setup
			self::setup_folders();
			
		}
	
		public function init() {
			//Cache logic
			if (self::is_cachable()) {
				self::start();
			}
		}
	
		private static function get_filename () {
			if ( defined('DOING_AJAX') && DOING_AJAX === true && $post_request_checksum !== false ) {
				return self::get_cache_dir().self::$post_request_checksum.".html.gz";
			} else {
				return self::get_cache_dir().self::$file_hash.".html.gz";
			}
		}
		
		public static function get_filename_from_url($url) {
			
			$parsed_url = parse_url(rtrim(trim($url,"/"), PHP_URL_PATH )); 
			
			if ( is_array( $parsed_url ) && isset ( $parsed_url['path'] ) ) {
				return md5($parsed_url['path']).".html.gz"; 
			} 
			
			return false;
		}
	
		public static function get_cache_dir() {
			return self::base_dir().self::$cache_folder.self::$domain_name."/";
		}
	
		private static function get_cache() {
	        return readgzfile(self::get_filename());
	    }
	
	    public static function setup_folders () {
		    if ( !is_dir( self::base_dir().self::$cache_folder.self::$domain_name."/" ) ) {
			    mkdir( self::base_dir().self::$cache_folder.self::$domain_name."/" , self::$dir_chmod, true);
			    self::chmod_r(self::base_dir()); //Set user rights 
		    }
	    }
		
		private static function chmod_r($path, $include_files = false) {
		   $master_dir = opendir($path);
		   while($file = readdir($master_dir)) {
		      if($file != "." AND $file != "..") {
		         if(is_dir($file)){
		            chmod($file, self::$dir_chmod);
		         }else{
			        if ( $include_files ) {
				        chmod($path."/".$file, self::$file_chmod);
			        } 
		            if(is_dir($path."/".$file)) {
		            	self::chmod_r($path."/".$file, true );
		            }
		         }
		      }
		   }
		   closedir($master_dir);
		}

	
	    private static function base_dir() {
		    if ( defined('WP_SIMPLE_CACHE_BASE_DIR') ) {
			    return rtrim( WP_SIMPLE_CACHE_BASE_DIR, "/");
		    } else {
			    return __DIR__;
		    }
	    }
	
	    public static function start() {
	
		    //Check if cache exists
		    if (file_exists(self::get_filename()) && (time() - self::$cache_time < filemtime(self::get_filename()))) {
		    	self::get_cache();
		    	exit;
		    } else {
				ob_start('WpSimpleCachePlugin\Cache\wp_simple_cache_plugin_end');
		    }
	    }
	
		public static function store_cache($callback_data) {
	
			//Go back to current dir (applys to some apache servers)
			chdir(dirname($_SERVER['SCRIPT_FILENAME']));
	
			//Check if cache is valid (empty pages should not be cached)
			if ( !empty( $callback_data ) ) {
	
				//Create handle
				$file_handle = fopen(self::get_filename(),"wa+");
	
				//Write new cache
				fwrite($file_handle, gzencode($callback_data, 9));
				
				//Set correct user rights
				chmod(self::get_filename(), self::$file_chmod);
	
			}
	
			//Return string according to ob_cache documentation
			return $callback_data;
	
		}
	
		//Clean cache
		public static function clean_cache() {
		    $files = glob(self::get_cache_dir()."*");
		    if ( !empty( $files ) && is_array( $files ) ) {
			    foreach($files as $file) {
			    	if(is_file($file)) {
					    unlink($file);
			    	}
			    }
		    }
	    }

		public static function is_blocked_url () {
	
			if ( is_array( self::$blocked_urls ) && !empty( self::$blocked_urls ) ) {
	
				foreach ( self::$blocked_urls as $blocked_url) {
					if ( preg_match("/".$blocked_url."/i", isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '' ) ) {
						return true;
					}
				}
	
			}
	
			return false;
	
		}
	
		private static function is_post_request () {
			if( isset( $_POST ) && !empty( $_POST ) ) {
				return true;
			} else {
				return false;
			}
		}
	
		private static function has_get_variable () {
			if( isset( $_GET ) && !empty( $_GET ) ) {
				return true;
			} else {
				return false;
			}
		}
	
		private static function is_logged_in () {
	
			if ( count( $_COOKIE ) ) {
	
				foreach($_COOKIE as $key => $value ){
	
				    if( preg_match("/wordpress_logged_in/i", $key ) ){
				        return true;
				    }
				}
	
			}
			return false;
	
		}
	
		private static function is_cachable () {
			
			//Is turned of
			if(defined('WP_SIMPLE_CACHE_DISABLED') && WP_SIMPLE_CACHE_DISABLED === true ) {
				return false; 
			}
			
			//Do not cache cronjobs 
			if(defined('DOING_CRON') && DOING_CRON === true ) {
				return false; 
			}
			
			//Cache ajax requests 
			if ((defined('DOING_AJAX') && DOING_AJAX === true) && !self::is_logged_in ()) {
				return true; 	
			}
			
			//Normal behaviour 
			if (!self::is_blocked_url() && !self::is_logged_in () && !self::is_post_request() && !self::has_get_variable ()) {
				return true;
			} else {
				return false;
			}
			
		}
		
	}

}

//Start cache
if ( class_exists('WpSimpleCachePlugin\Cache\WpSimpleCache') ) { 
	$wp_simple_cache = new WpSimpleCache();
	$wp_simple_cache->init();
}

// Function to pruge a page by wordpress post_id
if (!function_exists('WpSimpleCache_purge_post_by_id')) {
	
	function WpSimpleCache_purge_post_by_id($post_id, $purge_parent_page = true ) {
		
		if ( wp_is_post_revision( $post_id ) )
			return;

		global $wp_simple_cache;

		//Determine if init 
		if ( is_a( $wp_simple_cache, 'WpSimpleCachePlugin\Cache\WpSimpleCache' ) ) {  

			//Purge only this page, or purge all?
			if ( in_array(get_post_type( $post_id ), array("page","post") ) && ( $post_id != get_option('page_on_front') ) ) {
				
				//Purge this post 
				$file_name = $wp_simple_cache::get_cache_dir().$wp_simple_cache::get_filename_from_url(get_permalink( $post_id ));
				
				if ( file_exists( $file_name ) ) {
					unlink($file_name);
				}
				
				//Purge post parent 
				if ( $purge_parent_page === true  ) {
					$post_parent_id = wp_get_post_parent_id( $post_id );  
					if ( $post_parent_id !== 0 && is_numeric( $post_parent_id ) ) {
						$file_name = $wp_simple_cache::get_cache_dir().$wp_simple_cache::get_filename_from_url(get_permalink( $post_parent_id ));
						if ( file_exists( $file_name ) ) {
							unlink($file_name);
						}				
					}
				}
				
				//Purge archive page 
				$file_name = $wp_simple_cache::get_cache_dir().$wp_simple_cache::get_filename_from_url(get_post_type_archive_link(get_post_type( $post_id ) ) ); 
				if ( file_exists( $file_name ) ) {
					unlink($file_name);
				}	
				
			} else {
				$wp_simple_cache::clean_cache();
			}
		}
	}

	//Purge page on widget save
	add_filter('hbg_page_widget_save', function ($args) {
		if (isset($args['post_id'])) {
			\WpSimpleCachePlugin\Cache\WpSimpleCache_purge_post_by_id($args['post_id']);
		}
	});
	
	//Purge page on post id 
	add_action('save_post', '\WpSimpleCachePlugin\Cache\WpSimpleCache_purge_post_by_id', 999 );
	
	/* Purge page on querystring */ 
	add_action('init', function() {
		if ( isset($_GET['cache_empty_id']) && is_numeric( $_GET['cache_empty_id'] ) && is_user_logged_in()) {
			\WpSimpleCachePlugin\Cache\WpSimpleCache_purge_post_by_id($_GET['cache_empty_id']);
		} 
	});
	
}

//Purge all on menu save 
add_action('wp_update_nav_menu', function() {
	global $wp_simple_cache;
	$wp_simple_cache::clean_cache();
}, 999 );  

//Purge all on request 
add_action('init', function() {
	if ( isset($_GET['cache_empty_all']) && is_user_logged_in()) {
		global $wp_simple_cache;
		$wp_simple_cache::clean_cache();
	}
}, 999 );  

/* Visual stuff */

//Admin bar action buttons (Purge all)
add_action('admin_bar_menu', function($wp_admin_bar) {

	//Static settings 
	$settings = array(
					'id' => 'wp-simple-cache-clear-all',
					'title' => __('Töm hela cahcen','wp-simple-cache'),
					'meta' => array(
						'class' => 'wp-simple-cache-button'
					)
				); 

	//Create link 
	if ( is_admin() ) {
		$settings['href'] = admin_url( 'post.php?post=' . get_the_id() ) . '&action=edit&cache_empty_all'; 
	} else {
		$settings['href'] = get_permalink(get_the_id())."?cache_empty_all"; 
	}
	
	$wp_admin_bar->add_node($settings);
	
}, 1050);

//Admin bar action buttons (Purge this)
add_action('admin_bar_menu', function($wp_admin_bar) {
	
	//Static settings 
	$settings = array(
					'id' => 'wp-simple-cache-clear-this',
					'title' => __('Töm cahce för denna sida','wp-simple-cache'),
					'meta' => array(
						'class' => 'wp-simple-cache-button'
					)
				);

	//Create link 
	if ( is_admin() ) {
		$settings['href'] = admin_url( 'post.php?post=' . get_the_id() ) . '&action=edit&cache_empty_id='.get_the_id(); 
	} else {
		$settings['href'] = get_permalink(get_the_id())."?cache_empty_id=".get_the_id(); 
	}
	
	$wp_admin_bar->add_node($settings);
	
}, 1050);

//Admin bar styling
add_action('wp_head', function(){
	if(is_user_logged_in()) {
		echo '<style>.wp-simple-cache-button { background: rgba(255,255,255,.1) !important; margin-left: 20px !important; }</style>'; 
	}
}); 

//Add timestamp to footer
add_action('wp_footer', function(){
	echo "\n" . "<!-- Page cache by Really Simple Cache on ".date("Y-m-d H:i:s")."-->" . "\n";
}, 999 );