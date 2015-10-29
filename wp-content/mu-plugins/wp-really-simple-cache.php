<?php
	
	
	namespace WpSimpleCachePlugin\Cache;

	/*
	Plugin Name: RSCache
	Plugin URI:  http://wordpress.org/extend/plugins/health-check
	Description: Takes load of WordPress frontend by only generating a page once. Purging on save_post hook. 
	Author:      Sebastian Thulin
	*/
	
	/* Store callback */ //TODO: FIX THIS 
	function wp_simple_cache_plugin_end ( $data ) {
		
		//Cache data 
		$cache_instance = new WpSimpleCache(); 
		$cache_instance::store_cache($data); 
		
		//Return to output 
		return $data; 
		
	}
	
	global $wp_simple_cache; 
	
	Class WpSimpleCache {
		
		private static $file_hash; 
		private static $domain_name;
		private static $cache_time; 
		private static $cache_folder; 
		
		private static $blocked_urls; 
		
		public function __construct() {
			
			//Setup variables 
			self::$file_hash 		= md5($_SERVER['REQUEST_URI']); 
			self::$domain_name 		= md5($_SERVER['SERVER_NAME']); 
			self::$cache_time 		= 60 * 60 * 60 * 24; //In seconds  
			self::$cache_folder		= "/cache/";
			
			//What urls should not be cached? 
			self::$blocked_urls		= array("wp-admin","wp-login","secure"); 
			
			//Setup 
			self::setup_folders(); 

		}
		
		public function init() {
			//Cache logic 
			if (!self::blocked_url()) {
				self::start(); 
			}
		}
		
		private static function get_filename () {
			return self::get_cache_dir().self::$file_hash.".html.gz"; 
		}
		
		private static function get_cache_dir() {
			return __DIR__.self::$cache_folder.self::$domain_name."/"; 
		}
		
		private static function get_cache() {
	        return readgzfile(self::get_filename());
	    }
	    
	    public static function setup_folders () {
		    if ( !is_dir( __DIR__.self::$cache_folder  ) ) {
			    mkdir( __DIR__.self::$cache_folder , 0775, true);
		    }
		    if ( !is_dir( __DIR__.self::$cache_folder.self::$domain_name."/" ) ) {
			    mkdir( __DIR__.self::$cache_folder.self::$domain_name."/" , 0775, true);
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
		
		//BLOCK SOME URLS FROM CACHE 
		
		public static function blocked_url () {
			
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
		
		private static function is_cachable () {
			if ( self::blocked_url() && !self::is_logged_in () && !self::is_post_request() && !self::has_get_variable () ) { 
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
		
		public static function do_warmup () {
			
			//Ignore user abort
			ignore_user_abort(true);
			set_time_limit(60*5);

			//URL array to get
			$urls = array (
				
						//Startpage 
						'',
						
						//Top menus 
						'/startsida/arbete/',
						'/startsida/arbete/',
						'/startsida/forskola-och-utbildning/',
						'/startsida/kommun-och-politik/',
						'/startsida/omsorg-och-stod/',
						'/startsida/trafik-och-stadsplanering/',
						'/startsida/uppleva-och-gora/',
						
						//Most visited 
						'/startsida/forskola-och-utbildning/',
						'/startsida/arbete/arbeta-inom-helsingborgs-stad/lediga-jobb-i-helsingborgs-stad/',
						'/startsida/forskola-och-utbildning/vuxenutbildning/',
						'/startsida/trafik-och-stadsplanering/trafik-och-byggprojekt/olympia/',
						'/startsida/uppleva-och-gora/',
						'/startsida/bo-bygga-och-miljo/',
						'/startsida/forskola-och-utbildning/vuxenutbildning/ansokan-till-vuxenutbildning/',
						'/startsida/kommun-och-politik/vid-olyckor-och-kris/larm/',
						
					);
			
			//Count number if arrays 
			$url_count = count($urls);
			
			//Define 
			$curl_array = array();
			$ch = curl_multi_init();

			//Fetch url 
			foreach($urls as $count => $url) {
				$curl_array[$count] = curl_init("http://".$_SERVER['SERVER_NAME'].$url);
				curl_setopt($curl_array[$count], CURLOPT_RETURNTRANSFER, 1);
				curl_multi_add_handle($ch, $curl_array[$count]);
			}
			
			//Wait for it all to end 
			do {
				curl_multi_exec($ch, $exec);
			} while($exec > 0);
			
		}

	}
	
	//Start cache here (not in a hook)
	$wp_simple_cache = new WpSimpleCache(); 
	$wp_simple_cache->init(); 
	
	//Purge all on save_post 
	add_action('save_post', function( $post_id ){
		
		if ( wp_is_post_revision( $post_id ) )
			return;
			
		global $wp_simple_cache; 
		$wp_simple_cache::clean_cache(); 
		$wp_simple_cache::do_warmup(); 
		
	}, 999 );
	
	//Add timestamp to footer 
	add_action('wp_footer', function(){
		echo "<!-- Page cache by Really Simple Cache on ".date("Y-m-d H:i:s")."-->"; 
	}); 
	