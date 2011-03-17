<?php
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
