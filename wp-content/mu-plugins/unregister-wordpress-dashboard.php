<?php 
	
	/*
	Plugin Name: Helsingborg remove widgets
	Description: Less clutter on WordPress dashboard.
	Version:     1.0 
	Author:      Sebastian Thulin @ Helsingborgs Stad 
	*/
	
	add_action('wp_dashboard_setup', function () {
	
		global $wp_meta_boxes;
		
		// Remove wordpress dashboards 
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		
		// Remove yoast seo
		unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
		
		// Remove gravity forms
		unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
		
	}, 999 );