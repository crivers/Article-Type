<?php

/**
 * function: tip_type_mrt()
 * Params: $title, $count, $image, $topic_term, $skill_term
 * Requirments: your theme must support Widgets!
 *
 * @param $args An array of our arguments
 * @param $display Bool, default true, used to either return output 
 * as used in the short_code or to print outout
 */
function article_type_mrt($args=NULL, $display=TRUE) {
	global $post;
	
	/** 
	 * Set our default's and checkout our args/params
	 * they come in via an array, yes we trust them 
	 */	
	if (is_array( $args ))
		extract( $args );
 
	if (is_null( $category ))
		$category = '';

	if (empty( $image ) || $image == 'none')
		$image = 'no-image';
 
	if ($count == 0 )
		$count = 3;
		
	if (strtolower( $category ) == 'all')
		$category = null;
 
    /** Build our query for get_posts */
	$args = array(
		'post_type' => 'article',
		'category_name' => $category,
		'numberposts'=> $count,
		'offset' => 1
		);
		
	$myposts = get_posts( $args );
	$x = 1;
	$count = count( $myposts );
 
	if ( empty( $posted_on  ) )
		$posted_on = null;

    if ( empty( $posted_in ) ) 
		$posted_in = null;

	if ( empty( $excerpt  ) )
		$excerpt = null;

// call our views/most-recent.php
// passing in $title, $image <-- make that an array
// only pass in what WordPress needs to derive what it needs

	/**
	 * sometimes we wanna return
	 * sometimes we wanna print
	 * sometimes we wanna just go...
	 */
	if ( !$display )
		return $html;
	else 
		print $html;
}
