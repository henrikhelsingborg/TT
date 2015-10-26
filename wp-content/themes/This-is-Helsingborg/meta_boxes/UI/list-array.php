<?php
	
	//TODO: Remove this code. 
	
	if ( !function_exists('hbg_meta_box_ui') ) {
		
		function hbg_meta_box_ui () {
			
			// Get list categories from db table
			global $wpdb;
			
			try {
			    $listResult = $wpdb->get_results("SELECT title FROM list_categories ORDER BY id ASC", OBJECT);
			} catch (Exception $e) {
				$listResult = false; 
			}

			// Setup list categories as an array formatted array(0 => 'TITLE');
			$list = array();
			
			if ( !empty( $listResult ) ) { 
				
				foreach ($listResult as $item) {
				    $list[] = $item->title;
				}
				
			}
			
			return apply_filters('filter_hbg_meta_box_ui', $list); 
		}
	} 
	
	$list = hbg_meta_box_ui(); 