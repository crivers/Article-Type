<?php
/**
 * Registers custom post type "article", with category, tag, short-code and widget support
 *
 * @package WordPress
 * @since 3.1
 */

/**
 * Plugin Name: Article Type
 * Plugin URI: http://zmpbr.com/
 * Description: Registers custom post type "article", with category, tag, short-code and widget support
 * Version: 1.0.2
 * Author: Zane M. Kolnik
 * Author URI: http://zanematthew.com/
 * License: GPL
 */

/** Run our functions */
add_action( 'init', 'article_type' );

/** 
 * Register our Article
 *
 * Codex: http://codex.wordpress.org/Post_Types
 */
function article_type() {
    $labels = array(
	    'name' => _x('Article', 'post type general name'),
		'singular_name' => _x('article', 'post type singular name'),
		'add_new' => _x('Add New', 'article'),
		'add_new_item' => __('Add New article'),
		'edit_item' => __('Edit article'),
		'new_item' => __('New article'),
		'view_item' => __('View article'),
		'search_items' => __('Search article'),
		'not_found' =>  __('No article found'),
		'not_found_in_trash' => __('No article found in Trash'),
		'parent_item_colon' => ''
		);

	$supports = array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		'comments',
		'custom-fields',
		'trackbacks'
		);
    
    $capabilities = array(
        'edit_article'
        );
    
	$args = array(
		'labels' => $labels,
		'public' => true,
//		'capability_type' => 'post',
//		'capabilities' => $capabilities,
		'supports' => $supports,
		'rewrite' => array('slug' => 'articles')
		);

	register_post_type('article', $args);
    register_taxonomy_for_object_type( 'category', 'article' );
    register_taxonomy_for_object_type( 'post_tag', 'article' );
}

/** Add filter so CPT works with category and tag */
if ( ! function_exists( 'query_post_type' ) ) :
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
    /** 
     * hopefully this won't blow things up on the archive pages
     * if it does use get_post_types()
     */

    $post_types = get_post_types();
    if ( is_category() || is_tag()) {

        $post_type = get_query_var('article');

        if ( $post_type )
            $post_type = $post_type;
        else
            $post_type = $post_types;

        $query->set('post_type', $post_type);

    return $query;
    }
}
endif;