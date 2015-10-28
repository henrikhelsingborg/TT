<?php
	
	/*
	Plugin Name: RSCache
	Plugin URI:  http://wordpress.org/extend/plugins/health-check
	Description: Takes load of WordPress frontend by only generating a page once. Purging on save_post hook. 
	Author:      Sebastian Thulin
	*/
		
	/**
	 * JBCache is a filecache class for PHP
	 * Written by Jonas Björk <jonas.bjork@aller.se>
	 * 
	 * Contributing Developer: David V. Wallin <david@dwall.in>
	 *
	 * (C)2011 Aller Digitala Affärer, Aller media AB
	 * Licensed under GNU General Public License v2
	 */
	 
	//Polyfill
	if(!function_exists( 'getallheaders' )) {
	
		function getallheaders() {
	      
	        if (!is_array($_SERVER)) {
	            return array();
	        }
	
	        $headers = array();
	        foreach ($_SERVER as $name => $value) {
	            if (substr($name, 0, 5) == 'HTTP_') {
	                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
	            }
	        }
	        return $headers;
	        
	    }
	}
	 
	//Constants  
	define('CACHE_BASE_DIR', __DIR__ . "/cache/");
	define('CACHE_DIR', CACHE_BASE_DIR . $_SERVER['SERVER_NAME'] . "/" ); // cache directory
	define('CACHE_TIME', 60 * 60 * 60 * 24 * 7 );
	define('PURGE_USE', FALSE); // automatic purge of cache?
	define('PURGE_FACTOR', 100); // probability of cache purge, low number means higher probability
	define('GZIP_COMPRESSION', FALSE); // want gzip-compression or not?
	define('GZIP_LEVEL', 9); // define compression level (1-9, where 9 is highest)
	
	class RSCache {
	
	    private $cachefile;
	    private $fp;
	    private $has_cache;
	    private $m_time;
	    private $starttime;
	    private $endtime;
	    private $totaltime;
	
	    /**
	     * Construction area. Please bring some concrete.
	     */
	    public function __construct($identifier = NULL) {
	        $m_time = explode(" ", microtime());
	        $m_time = $m_time[0] + $m_time[1];
	        $this->starttime = $m_time;
	
	        if ($identifier) {
	            $this->start($identifier);
	        } else {
	            $this->cachefile = "";
	            $this->fp = NULL;
	            $this->has_cache = FALSE;
	        }
	
	    }
	
	    public function __destruct() {
	        $this->stop();
	    }
	
	    /**
	     * Should we show compressed content or not?
	     * 
	     * @param none
	     * @return Nothing - Includes or reads the file
	     * @author David V. Wallin <david@dwall.in>
	     */
	    private function show_cached_content() {
	        if (GZIP_COMPRESSION == TRUE) {
	            readgzfile($this->cachefile);
	        } elseif (GZIP_COMPRESSION == FALSE) {
	            include($this->cachefile);
	        } else {
	            return false;
	        }
	    }
	
	    /**
	     * Set the name of the cached file
	     * 
	     * @param string $identifier Something to identify the file you're caching.
	     * @return string With either .html or .html.gz as a fileending
	     * @author David V. Wallin <david@dwall.in>
	     */
	    private function start_cache_file($identifier = NULL) {
	
	        if ( GZIP_COMPRESSION == TRUE ) {
	            return CACHE_DIR . sha1($identifier) . ".html.gz";
	        } elseif (GZIP_COMPRESSION == FALSE) {
	            return CACHE_DIR . sha1($identifier) . ".html";
	        } else {
	            return false;
	        }
	    }
	
	    /**
	     * Start the cache wrapper
	     *
	     * @param string $identifier Something to identify the file you're caching.
	     * @return boolean Successful or not?
	     */
	    public function start($identifier = NULL) {

			$this->create_cache_dir(); 

	       	if (PURGE_USE) {
	            $this->purge_probe();
	        }
	
	        $this->cachefile = $this->start_cache_file($identifier);
	
	        if (file_exists($this->cachefile) && (time() - CACHE_TIME < filemtime($this->cachefile))) {
	            $this->show_cached_content();
	            exit;
	        } else {
	            if (!is_writeable(CACHE_DIR))
	                return FALSE;
	            $this->fp = fopen($this->cachefile, 'c');
	            if (!$this->fp)
	                return FALSE;
	
	            $this->has_cache = TRUE;
	            ob_start();
	            return true;
	        }
	    }
	    
	    public function create_cache_dir () {
		    
		    //Make shure that /cache/ dir exists 
		    if ( !is_dir( CACHE_BASE_DIR ) ) {
			    mkdir( CACHE_BASE_DIR, 0775, true);
		    }
		    
		    //Make shure that /cache/domain/ exists 
		    if ( !is_dir( CACHE_DIR ) ) {
			    mkdir( CACHE_DIR, 0775, true);
		    }
		    
	    }
	
	    /**
	     * Writes the file-content to the cached file. Either compressed or not.
	     * 
	     * @param none
	     * @return false if GZIP_COMPRESSION isn't defined otherwise just writes.
	     * @author David V. Wallin <david@dwall.in>
	     */
	    private function write_file_content() {
	      
	        $page = ob_get_contents();

	        if ( !empty( $page ) ) { 
	        
		        if (GZIP_COMPRESSION == TRUE) {
		            fwrite($this->fp, gzencode($page, GZIP_LEVEL));
		        } elseif (GZIP_COMPRESSION == FALSE) {
		            fwrite($this->fp, $page);
		        } else {
		            return false;
		        }

	        } else {
		        unlink($this->fp); 
	        }
	        
			return $page;
			
	    }
	
	    /**
	     * Stop the cache wrapper, save rendered page to file.
	     *
	     * @return boolean Successful or not?
	     */
	    public function stop() {
	        if (!$this->has_cache)
	            return FALSE;
	        if ($this->has_cache && $this->fp) {
	            $rounder = 6;
	            $m_time = explode(" ", microtime());
	            $m_time = $m_time[0] + $m_time[1];
	            $endtime = $m_time;
	            $totaltime = ($endtime - $this->starttime);
	            printf("<!-- This page was delivered from cache. - %s -->\n", date("Y-m-d H:i:s"));
	
	            $this->write_file_content();
	            fclose($this->fp);
	            ob_end_flush();
		    print $page; 
	            $this->has_cache = FALSE;
	            return TRUE;
	        } else {
	            return FALSE;
	        }
	    }
	
	    public function has_cache() {
	        return $this->has_cache;
	    }
	
	    /**
	     * Purge the cached files. Using mtime on file and CACHE_TIME constant.
	     */
	    public function purge() {
	        $handle = opendir(CACHE_DIR);
	        if ($handle) {
	            while (false !== ($file = readdir($handle))) {
	                if ($file != "." && $file != "..") {
	                    if ((time() - filemtime(CACHE_DIR . $file)) > CACHE_TIME) {
	                        unlink(CACHE_DIR . $file);
	                    }
	                }
	            }
	            closedir($handle);
	        }
	    }
	    
	    public function clean_cache( $only_empty = false ) {
		    $files = glob(CACHE_DIR."*");
		    if ( !empty( $files ) && is_array( $files ) ) {
			    foreach($files as $file) {
			    	if(is_file($file)) {
				    	if ( !$only_empty )  {
					    	unlink($file); 
				    	} else {
					    	if (empty(filesize($file))) {
						    	unlink($file); 
					    	}
				    	}
			    	}
			    }
		    }
	    }
	
	    /**
	     * Probe if we should purge cache or not.
	     * Using randomization for probe. Set PURGE_FACTOR to:
	     * - low value for high probability of purging
	     * - high value for low probability of purging
	     * 
	     * @return boolean
	     */
	    private function purge_probe() {
	        $needle = ceil(PURGE_FACTOR / 2);
	        srand(time());
	        $r = rand() % PURGE_FACTOR;
	        if ($r == $needle) {
	            $this->purge();
	            return TRUE;
	        } else {
	            return FALSE;
	        }
	    }
	
	
		public function blocked_url () {
			
			$mathing_urls = array("wp-admin","wp-login","secure","admin-ajax"); 
			
			if ( is_array( $mathing_urls ) && !empty( $mathing_urls ) ) {  
			
				foreach ( $mathing_urls as $matching_url) {
					if ( preg_match("/".$matching_url."/i", !empty( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '' ) ) {
						return false; 
					} 
				} 
	
			}
			
			return true; 
			
		} 
		
		public function is_post_request () {
			if( isset( $_POST ) && !empty( $_POST ) ) {
				return true; 
			} else {
				return false; 
			}
		}
		
		public function has_get_variable () {
			if( isset( $_GET ) && !empty( $_GET ) ) {
				return true; 
			} else {
				return false; 
			}
		}
		
		public function is_cachable () {
			if ( $this->blocked_url() && !$this->is_logged_in () && !$this->is_post_request() && !$this->has_get_variable () ) { 
				return true; 
			} else {
				return false; 
			}
		}
		
		public function is_logged_in () {
	
			if ( count( $_COOKIE ) ) {
				
				foreach($_COOKIE as $key => $value ){
	
				    if( preg_match("/wordpress_logged_in/i", $key ) && !empty( $value ) ){
				        return true; 
				    }
				}
	
			}
			return false; 
			
		}
		
		public function do_warmup () {
			
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
				curl_setopt($curl_array[$count], CURLOPT_HTTPHEADER, array('NO-CACHE-REDO: do-not-create'));
				curl_multi_add_handle($ch, $curl_array[$count]);
			}
			
			//Wait for it all to end 
			do {
				curl_multi_exec($ch, $exec);
			} while($exec > 0);
			
		}
	
	}
	
	//Create class 
	global $wp_really_simple_cache; 
	$wp_really_simple_cache = new RSCache();

	//Run cache if valid page 
	if ( $wp_really_simple_cache->is_cachable () ) { 
		$wp_really_simple_cache->start($_SERVER['REQUEST_URI']);
	}
	
	//Purge all on save_post 
	add_action('save_post', function( $post_id ){
		
		if ( wp_is_post_revision( $post_id ) )
			return;
			
		$wp_really_simple_cache = new RSCache();
		$wp_really_simple_cache->clean_cache(); 
		$wp_really_simple_cache->do_warmup(); 
		
	}, 999 );

	//Safety pin for themes who are missing the stop() function. 
	add_action('shutdown', function(){
		if (!array_key_exists("NO-CACHE-REDO",getallheaders())) {
			global $wp_really_simple_cache; 
			$wp_really_simple_cache->clean_cache(true); 
		}
	}); 


	/**********************************
	Add this to footer in your theme!  
	
		//Cache end 
		global $wp_really_simple_cache; 
		if ( $wp_really_simple_cache->is_cachable () ) { 
			$wp_really_simple_cache->stop($_SERVER['REQUEST_URI']);
	  	}
	  	
  	*/ 