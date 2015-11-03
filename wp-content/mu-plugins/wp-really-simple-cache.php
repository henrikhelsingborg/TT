<?php

namespace WpSimpleCachePlugin\Cache;

/*
Plugin Name: Simple File Cache for WordPress
Plugin URI:  http://sebastianthulin.se/simple-cache/
Description: A Simple and Effective File-cache for WordPress.
Author:      Sebastian Thulin @ Helsingborg Stad
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
	
		public function __construct() {
	
			//Setup variables
			self::$file_hash 		= md5(rtrim(trim($_SERVER['REQUEST_URI']),"/"));
			self::$domain_name 		= md5($_SERVER['SERVER_NAME']);
			self::$cache_time 		= 60 * 60 * 60 * 24 * 7; //In seconds
			self::$cache_folder		= "/cache/";
			
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
			return self::get_cache_dir().self::$file_hash.".html.gz";
		}
		
		public static function get_filename_from_url($url) {
			return md5(parse_url(rtrim(trim($url,"/"), PHP_URL_PATH ))).".html.gz"; 
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
			if ( !self::is_blocked_url() && !self::is_logged_in () && !self::is_post_request() && !self::has_get_variable () ) {
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
		if ( is_a( $wp_simple_cache, 'WpSimpleCache' ) ) {  
	
			//Purge only this page, or purge all?
			if ( in_array(get_post_type( $post_id ), array("page","post") ) ) {
				
				//Purge this post 
				$file_name = $wp_simple_cache::get_cache_dir().$wp_simple_cache::get_filename_from_url(get_permalink(  $post_id ));
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
				
			} else {
				$wp_simple_cache::clean_cache();
			}
		}
	}

	//Purge all on save_post
	add_action('save_post', '\WpSimpleCachePlugin\Cache\WpSimpleCache_purge_post_by_id', 999 );

	//Purge page on widget save
	add_filter('hbg_page_widget_save', function ($args) {
		if (isset($args['post_id'])) {
			\WpSimpleCachePlugin\Cache\WpSimpleCache_purge_post_by_id($args['post_id']);
		}
	});
}

//Add timestamp to footer
add_action('wp_footer', function(){
	echo "\n" . "<!-- Page cache by Really Simple Cache on ".date("Y-m-d H:i:s")."-->" . "\n";
});
