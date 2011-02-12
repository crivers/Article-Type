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

/**
 * Add Widget support:
 * Title
 * Count
 * Choose category to display 
 * Choose tag to display
 * Choose Image to display
 * Show post on
 * Show post in
 *
 * Requirments: your theme must support Widgets! 
 * The bulk of this class was taken from the codex, see codex for docs
 * Codex: http://codex.wordpress.org/Widgets_API#Widgets_API
 * 
 * no need to init, get init'd via wp, see add_action below
 */
class MostRecentArticles extends WP_Widget {
    /** constructor */
    function MostRecentArticles() {
        parent::WP_Widget(false, $name = 'Most Recent Articles');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = array('title' => apply_filters('widget_title', $instance['title']),
            'count' => apply_filters('widget_count', $instance['count']),
            'category' => apply_filters('widget_category', $instance['category']),
            'image' => apply_filters('widget_image', $instance['image']),
            'posted_on' => apply_filters('widget_image', $instance['posted_on']),
            'posted_in' => apply_filters('widget_image', $instance['posted_in']),
            'excerpt' => apply_filters('widget_image', $instance['excerpt'])
            );

        echo $before_widget;
        article_type_mrt($title);
        echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = strip_tags($new_instance['count']);
        $instance['category'] = strip_tags($new_instance['category']);
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['posted_on'] = strip_tags($new_instance['posted_on']);
        $instance['posted_in'] = strip_tags($new_instance['posted_in']);
        $instance['excerpt'] = strip_tags($new_instance['excerpt']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {

        $title = (isset($instance['title'])) ? esc_attr($instance['title']) : 'no title';
        $count = (isset($instance['count'])) ? esc_attr($instance['count']) : 0;
        $category = (isset($instance['category'])) ? esc_attr($instance['category']) : '';
        $image = (isset($instance['image'])) ? esc_attr($instance['image']) : 0;
        $posted_on = (isset($instance['posted_on'])) ? esc_attr($instance['posted_on']) : 0;
        $posted_in = (isset($instance['posted_in'])) ? esc_attr($instance['posted_in']) : 0;
        $excerpt = (isset($instance['excerpt'])) ? esc_attr($instance['excerpt']) : 0;

        /** 
         * Pretty cool, get our regsitered image sizes
         * Codex: http://core.trac.wordpress.org/browser/tags/3.0.4/wp-includes/media.php
         */
        global $_wp_additional_image_sizes;

        $image_sizes = $_wp_additional_image_sizes;
        $categories = get_terms('category');
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Count:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>">
            <?php _e('Category:'); ?>
            <select name="<?php echo $this->get_field_name('category'); ?>">
                <option value="all" <?php if ($category == 'all') : ?>selected="selected"<?php endif; ?>>All</option>            
                <?php foreach ($categories as $cat) : ?>
                    <option value="<?php echo $cat->slug; ?>" <?php if ($cat->slug == $category) : ?>selected="selected"<?php endif; ?>><?php echo $cat->name; ?></option>
                <?php endforeach; ?>
            </select>
            </label>
        </p>
        <p>
        <label for="<?php echo $this->get_field_id('image'); ?>" class="title">
            <?php _e('Show image'); ?>
            <select name="<?php echo $this->get_field_name('image'); ?>">
                <option value="none" <?php if ('none' == $image) : ?>selected="selected"<?php endif; ?>>None</option>
                <?php foreach ($image_sizes as $image_size=>$size) : ?>
                    <option value="<?php echo $image_size; ?>" <?php if ($image_size == $image) : ?>selected="selected"<?php endif; ?>><?php echo $image_size; ?> (<?php echo $size['height']; ?> x <?php echo $size['width'];?>)</option>
                <?php endforeach; ?>
            </select>
        </label>
        </p>
        <p><label for="<?php echo $this->get_field_id('posted_on'); ?>"><input id="<?php echo $this->get_field_id('posted_on'); ?>" name="<?php echo $this->get_field_name('posted_on'); ?>" type="checkbox" <?php if ( $posted_on ) echo 'checked'; ?>" /> <?php _e('Show posted on'); ?></label></p>
        <p><label for="<?php echo $this->get_field_id('posted_in'); ?>"><input id="<?php echo $this->get_field_id('posted_in'); ?>" name="<?php echo $this->get_field_name('posted_in'); ?>" type="checkbox" <?php if ( $posted_in ) echo 'checked'; ?>" /> <?php _e('Show posted in'); ?></label></p>
        <p><label for="<?php echo $this->get_field_id('excerpt'); ?>"><input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" <?php if ( $excerpt ) echo 'checked'; ?>" /> <?php _e('Show excerpt'); ?></label></p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("MostRecentArticles");'));

/** Some short code that might be useful */
add_shortcode('META_LIST', 'article_type_meta_list');
function article_type_meta_list($atts, $content=NULL) {
    $booo =  "<div class='article-type-meta-list'>{$content}</div>";
    return $booo;
}

add_shortcode('META_BOX', 'article_type_meta_box');
function article_type_meta_box($atts, $content=NULL) {
    $booo =  "<div class='article-type-meta-box'>{$content}</div>";
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

	$html = null;
	$html .= "<h2 class='widget-title'>{$title}</h2>";
	/** 
	 * @todo take this one step further and pass in the height width of our image
	 * then in the css do something like: overflow: hidden; height: value; width: value; 
	 * thus forcing the layout to be correct, or just run "regenerate thumbs!" tanks viper007!
	 */
	$html .= "<ul class='{$image}'>";
 
	foreach( $myposts as $post ) {            
		$odd_even_css = ($x % 2) ? ' odd ' : ' even '; 
		$helper_css = ($x == $count) ? ' last ': '';
		$html .= "<li class='{$odd_even_css} {$helper_css}'>"; 
			
		setup_postdata( $post );
 
		if ($image != 'no-image') {
			$html .= '<div class="image">';
			$html .= '<a href="' . get_permalink() . '" rel="Permalink for '. get_the_title().'" title="Continue reading: '.get_the_title().'">';

			if ( function_exists( 'has_post_thumbnail' ) )
			   $html .= get_the_post_thumbnail($post->ID, $image); 

			$html .= '</a>';
			$html .= '</div>';
		}
		
		$html .= '<div class="">';
		$html .= '<h2 class="title"><a href="'.get_permalink() .'" rel="Permalink for '.get_the_title() .'" title="Continue reading: ' . get_the_title() . '">' . get_the_title() . '</a></h2>';
 
		if ( $posted_on )
			foreach ( get_the_category() as $cat )
				$html .= '<span class="category">Category <a href="'.get_category_link($cat->cat_ID) . '" title="View all in: '.$cat->name.'">' . $cat->name . ' </a></span>';
		
		if ( $posted_in )
			$html .= '<span class="date">Posted on <em>' . get_the_modified_time('m/d/Y') . '</em></span>';

		if ( $excerpt ) 
			$html .= '<span class="excerpt">' . get_the_excerpt() . '</span>';
 
		$html .= '</div>';
		$html .= '</li>';
		
		/** note x++ does not equal xxx :( */
		$x++;
	}
	wp_reset_query();
	$html .= "</ul>";
	
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
