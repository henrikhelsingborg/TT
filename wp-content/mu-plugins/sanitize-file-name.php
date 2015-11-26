<?php
	
	/*
	Plugin Name: Helsingborg santitize file names
	Description: Remove special carachers from uploaded files. 
	Version:     1.0 
	Author:      Sebastian Thulin @ Helsingborgs Stad 
	*/
	
	add_action('wp_handle_upload_prefilter', function($file) {
		
		$path 			= pathinfo($file['name']);
		$new_filename 	= preg_replace('/.' . $path['extension'] . '$/', '', $file['name']);
		$file['name'] 	= sanitize_title($new_filename) . '.' . $path['extension'];

		return $file;
		
	}); 