<?php

/** Some short code that might be useful */
add_shortcode('IMPORTANT_NOTE', 'important_note');
function important_note($atts, $content=NULL) {
    // pass in $content
    // call our view/container.php
    // return and display our view
    // use shortcode name as css class 'important_note'
    return $booo;
}

add_shortcode('FOOT_NOTES', 'foot_notes');
function foot_notes($atts, $content=NULL) {
    // pass in $content
    // call our view/container.php
    // return and display our view
    // use shortcode name as css class 'foot_notes'
    return $booo;
}

add_shortcode('TWEET_BUTTON', 'tweet_button');
function tweet_button() { 
    // call our view/tweet-button.php
}


/** Some short code that might be useful */
add_shortcode('META_LIST', 'article_type_meta_list');
function article_type_meta_list($atts, $content=NULL) {
    // pass in $content
    // call our view/container.php
    // return and display our view
    // use shortcode name as css class 'article_type_meta_list'
    return $booo;
}

add_shortcode('META_BOX', 'article_type_meta_box');
function article_type_meta_box($atts, $content=NULL) {
    // pass in $content
    // call our view/container.php
    // return and display our view
    // use shortcode name as css class 'article_type_meta_box'
    return $booo;
}

add_shortcode('ARTICLE_MRT', 'article_type_mrt_box');
function article_type_mrt_box($atts, $content=NULL) {
    
    /** If we have attributes from the short code use them */
    if ( !empty( $atts )) {

        /** 
         * Allowed attributes, we're not getting crazy on this ish 
         * @todo check for atts can be more extensive
         * @todo could possibly add more atts
         * shortcode_atts returns an array!
         */
        extract( shortcode_atts( array(
                'title', 
                'count', 
                'category'
                ), $atts ) );
        
        /** check if things are there */
        if ( empty( $atts['title'] ) )
            $atts['title'] = 'Recent Articles';
        
        if ( empty( $atts['count'] ) ) 
             $atts['count'] = 5;
        
        /** pretty cool, man so much is already done for us :) */
        if ( term_exists($atts['category']) )
            $atts['category'] = $atts['category'];
        
        $args = array(
            'count' => $atts['count'],
            'category' => $atts['category'],
            'title' => $atts['title']
            );
            
    } else {    
        $args = array(
            'count' => 5,
            'image' => 'none',
            'category' => 'all',
            'title' => 'Recent Articles'
         );
    }
    
    return '<div class="article-mrt">' . article_type_mrt($args, false) . '</div>';
}