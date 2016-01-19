<?php 
	
	/*
	Plugin Name: Helsingborg brand WordPress
	Description: Add name to footer and support email link 
	Version:     1.0 
	Author:      Sebastian Thulin @ Helsingborgs Stad 
	*/
	
	add_filter('admin_footer_text', function () {
		echo __("Helsingborgs stad") . ' | ' . '<a href="mailto:webbredaktionen@helsingborg.se">' . __("Mejla supporten") . '</a>'; 
	});