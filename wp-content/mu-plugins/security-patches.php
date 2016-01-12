<?php 
	
	/*
	Plugin Name: Helsingborg wp-core secutiry patches 
	Description: Applying security functions to WordPress
	Version:     1.0 
	Author:      Sebastian Thulin @ Helsingborgs Stad 
	*/
	
	//Remove wordpress generator value
	add_filter('the_generator', function(){
		return ""; 	
	}); 

	//Remove version from admin footer & generator tags
	remove_filter( 'update_footer', 'core_update_footer' ); 
	remove_action( 'wp_head', 'wp_generator' );
	
	//Remove xml-rpc functionality 
	add_filter('xmlrpc_enabled', '__return_false');
