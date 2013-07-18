<?php
/*
Plugin Name: URLShortener Demo
Plugin URI: https://github.com/mduran16/urlShortener
Description: In this example, posts are used as containers for link information for a url
shortening service.

Version: yes
Author: Matt Duran
Author URI: https://github.com/mduran16/urlShortener
License: yes
*/

add_action('init','urlRedirector');
add_action('add_meta_boxes','meta_box');

function urlRedirector(){
	$labels = array(
		'name' => 'urls',
		'singular_name' => 'urls',
		'add_new' => 'Add new url',
		'add_new_item' => 'Add New url',
		'edit_item' => 'Edit url',
		'new_item' => 'New url',
		'all_items' => 'All url',
		'view_item' => 'View url',
		'search_items' => 'Search url',
		'not_found' =>  'No url found',
		'not_found_in_trash' => 'No url found in Trash', 
		'parent_item_colon' => '',
		'menu_name' => 'URLs'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => array( 'slug' => 'url' ),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => 25,
		'supports' => array( 'title')
	); 
	register_post_type( 'urls', $args );

	//here comes the query
	$query = new WP_Query(array('post_type' => array('urls')));
    while ($query->have_posts()) : $query->the_post();
		global $post;

		//if the post meta 'urlid' hasnt been created yet, create one now
		if(get_post_meta($post->ID,'urlid',true) == false){
			$string = '';
			//8 digit random number combination
			for($i = 0; $i < 8; $i++)
				$string = $string . rand(0,9);
			//add it to the post aka link
			add_post_meta($id = $post->ID,$key = 'urlid',$ $value = $string,true);
		}
		//
		if(get_post_meta($post->ID,'urlid',true) == $_SERVER["REQUEST_URI"]){
			header('Location: ' . $post->post_title);
			die();
		}

	endwhile;
}

function meta_box(){
	global $post;
	if(get_post_meta($post->ID,'urlid',true))
		add_meta_box('url_prompt','Shortened URL','shortenedurl','urls','normal');
}

function shortenedurl(){
	global $post;
	echo "<h2>". site_url() . "/" . get_post_meta($post->ID,'urlid',true) . "</h2>";
}

function createURL(){
	$name = $_REQUEST['url'];
	$my_post = array(
	  'post_title'    => $name,
	  'post_status'   => 'publish',
	  'post_type'	  => 'urls',
	);
	$postID = wp_insert_post($my_post);

	$url['link'] = site_url() . "/" . get_post_meta($postID,'urlid',true);

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		$url = json_encode($url);
		echo $url;
	}
	else{
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
	die();
}



