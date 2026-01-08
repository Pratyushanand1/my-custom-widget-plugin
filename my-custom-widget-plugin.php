<?php
/*
Plugin Name: My Custom Widget
Description: A simple widget to display recent posts.
Version: 1.0
Author: Pratyush Anand
*/

class My_Custom_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'my_custom_widget', 
            __('My Custom Widget', 'text_domain'), 
            array('description' => __('A widget to display recent posts', 'text_domain'),)
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        // Display recent posts
        $recent_posts = wp_get_recent_posts(array('numberposts' => 5));
        echo '<ul>';
        foreach ($recent_posts as $post) {
            echo '<li><a href="' . get_permalink($post['ID']) . '">' . esc_html($post['post_title']) . '</a></li>';
        }
        echo '</ul>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Posts', 'text_domain');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'text_domain'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php 
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

function register_my_custom_widget() {
    register_widget('My_Custom_Widget');
}

add_action('widgets_init', 'register_my_custom_widget');
