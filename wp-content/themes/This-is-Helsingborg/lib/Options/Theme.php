<?php

namespace Helsingborg\Options;

class Theme
{
    public function __construct()
    {
		
        if ((defined("WP_ENABLE_THEME_SETTINGS") && WP_ENABLE_THEME_SETTINGS === true)) { //THIS FUNCTION IS OPTIONAL FOR NOW 
	        add_action('init', array($this, 'functionsAdminPanel'), 11);
	        add_action('init', array($this, 'settingsAdminPanel'), 11);
	    }
        
    }
    
    /* Manage avabile functions in site - What modules should we use? */ 
    public function functionsAdminPanel () {
	   
	    if( function_exists('acf_add_options_page') ) {
			
			acf_add_options_page(array(
				'page_title' 	=> __("Theme Functions",'helsingborg'),
				'menu_title' 	=> __("Theme Functions",'helsingborg'),
				'menu_slug' 	=> __("Theme Functions",'helsingborg'),
				'capability' 	=> 'read',
				'redirect' 		=> false
			));
			
			if ( !class_exists('Disable_Comments') ) {
				
				if ( true ) { //Todo: Only show if told to inacive comments. 
					add_action( 'admin_notices', function(){
						$this->updatedMessage(__("Some functions in this theme requires: Disable Comments Plugin",'helsingborg'), true); 
					});
				}
				
			} 
		
		} else {
			add_action( 'admin_notices', function(){
				$this->updatedMessage(__("Some functions in this theme required Advanced Custom Fields PRO",'helsingborg'), true ); 
			});
		}
		
    }
    
    public function getThemeFunctions () {
	    
	    return array(
		    'general'			=> true,
		    'color' 			=> true, 
		    'logo'				=> true,
		    'blog'				=> true,
		    'search' 			=> true,
		    'comments' 			=> true,
		    'news'				=> true,
		    'seo' 				=> true, 
		    'inheritedcontent' 	=> true
	    ); 
	    
    }
    
    /* Use data from module above - Create settings menu */ 
    public function settingsAdminPanel() {
	    
	    $active_modules = array_filter($this->getThemeFunctions()); 
	    
	    if ( !empty( $active_modules ) && is_array( $active_modules ) ) {
		    
		    //Add master node page 
		    if ( function_exists( 'acf_add_options_page' ) ) { 
			    acf_add_options_page(array(
					'page_title' 	=> 'Theme Settings',
					'menu_title'	=> 'Theme Settings',
					'menu_slug' 	=> 'theme-settings',
					'capability'	=> 'edit_posts',
					'redirect'		=> true
				));
			} else {
				wp_die(__("Error: Could not find ACF function required (acf_add_options_page).", 'helsingborg'), __("ACF ERROR") ); 	
			}

		    foreach ( $active_modules as $theme_function_key => $theme_function_state ) {

			 	//Import configuration pattern
			    if ( $theme_function_state === true && file_exists( __DIR__ . "/config/" . $theme_function_key . ".php" )) {
					
					//Include configuration
					require_once( __DIR__ . "/config/" . $theme_function_key . ".php" ); 

					//Default module tab configuraion
					$module = array_merge(array(
						'menu_name' 		=> __("Module:") . $theme_function_key,
						'title' 			=> __("Module:") . $theme_function_key,
					), $module ); 
					
					//Create options page 
					if ( function_exists( 'acf_add_options_sub_page' ) ) { 
						acf_add_options_sub_page(array(
							'page_title' 	=> $module['menu_name'],
							'menu_title'	=> $module['title'],
							'parent_slug'	=> 'theme-settings'
						));
						
					} else {
						wp_die(__("Error: Could not find ACF function required (acf_add_options_sub_page).", 'helsingborg'), __("ACF ERROR") ); 						
					}
					
			    } else {
				    add_action( 'admin_notices', function(){
				    	$this->updatedMessage("Configuration file is missing in <strong>" . __FILE__ . "</strong>" , true ); 
				    }); 
			    }
			
		    }
		
	    }
		
		$this->updatedMessage(__("There was an error creating required settings pages for this theme. Invalid configuration object.", 'helsingborg'), true ); 
	    
    }
    
    public function updatedMessage( $message, $superadmin = false ) {
	   
	    if (!empty($message)) { 
		    if (($superadmin === false)||($superadmin===true&&is_super_admin())) {
			    echo '<div class="updated"><p>'; 
					echo $message; 
				echo '</p></div>'; 
		    } 
		}
		
    } 
    
}
