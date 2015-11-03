<?php
	
	/*
	Plugin Name: Helsingborg filter filetypes
	Description: Adding more filter options to WordPress media-library
	Version:     1.0 
	Author:      Sebastian Thulin @ Helsingborgs Stad 
	*/
	
	add_filter( 'post_mime_types', function ( $post_mime_types ) {
        $post_mime_types['application/msword'] = array( __( 'DOCs' ), __( 'Hantera DOC' ), _n_noop( 'DOC <span class="count">(%s)</span>', 'DOC <span class="count">(%s)</span>' ) );
        $post_mime_types['application/vnd.ms-excel'] = array( __( 'XLS' ), __( 'Hantera XLS' ), _n_noop( 'XLS <span class="count">(%s)</span>', 'XLSs <span class="count">(%s)</span>' ) );
        $post_mime_types['application/pdf'] = array( __( 'PDF' ), __( 'Hantera PDF' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDF <span class="count">(%s)</span>' ) );
        $post_mime_types['application/zip'] = array( __( 'ZIP' ), __( 'Hantera ZIP' ), _n_noop( 'ZIP <span class="count">(%s)</span>', 'ZIP <span class="count">(%s)</span>' ) );
        return $post_mime_types;
	}); 
