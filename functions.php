<?php 
	register_nav_menus(); 
	
	// This is to remove the in-page styling of the galleries:
	add_filter( 'use_default_gallery_style', '__return_false' );
	
	// This is for posts to have a thumb nail
	add_theme_support( 'post-thumbnails' );
	
	remove_action('wp_head', 'start_post_rel_link', 10, 0 );
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');

	// This is to remove the admin bar on top of the web site:
	add_filter( 'show_admin_bar' , 'geraldvatrin_has_no_admin_bar');
	function geraldvatrin_has_no_admin_bar() 
	{ 
		return false; 
	}

	// This is to include js libraries  
	add_action( 'wp_enqueue_scripts', 'marvinzilm_scripts_with_jquery' );
	function marvinzilm_scripts_with_jquery()  
	{  
		wp_register_script( 'marvinzilm-script', get_template_directory_uri() . '/marvinzilm.js', array( 'jquery' ) );
		wp_enqueue_script( 'marvinzilm-script' );  
	}
	
	// If more than one page exists, return TRUE.
	function show_posts_nav() 
	{
	    global $wp_query;
	    return ($wp_query->max_num_pages > 1);
	}
?>