<?php
// another function TEST for multiple widget to page -------------------------------------------

/**
 * Adds Custom Form widget. TEST TESt
 */
class short_blogy extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct( //need to check details ... YES
			'short_blogy', // Base ID
			__( 'Short Blogy', 'text_domain' ), // Name ** UPDATE NAME HERE text_domain+>tutplustextdomain
			array(
        'classname' => 'short_blogy',
        'description' => __( 'Very basic blog form, and include image, title, and short paragraph', 'text_domain')
      )
		);
    load_plugin_textdomain('text_domain', false, basename(dirname(__FILE__)).'/languages');
	} //constract function done before here

	/**
	 * Back-end display of widget.
	 */
	public function form( $instance ) {
		// creates the back-end form
		echo '<pre>';
		print_r($instance);
		echo '</pre>';
		$thumbnail = esc_attr($instance['thumbnail']);
    $title = esc_attr($instance['title']);
    $paragraph = esc_attr($instance['paragraph']);
    ?>

		<div class="row">
			<div class="col-md-3">
				<img for="<?php echo $this->get_field_id('thumbnail'); ?>" src="../assets/images/image_place_holder.png" class="img-thumbnail" width="200" height="200">
			</div>
			<div class="col-md-9">
				<div>
					<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
					<input class="blog_p" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
				</div>
				<div>
					<label for="<?php echo $this->get_field_id('paragraph'); ?>"><?php _e('Short Paragraph:'); ?></label>
					<textarea class="blog_p" id="<?php echo $this->get_field_id('paragraph'); ?>" name="<?php echo $this->get_field_name('paragraph'); ?>"><?php echo $paragraph; ?></textarea>
				</div>
			</div>
		</div>

    <?php
	}

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract($args);

		// ASK !..... about apply_filters and HOW
		$thumbnail = apply_filters('widget_thumbnail', $instance['thumbnail']);
		$title = $instance['title'];
		$paragraph = $instance['paragraph'];

		echo $before_widget;

		if($thumbnail) {
			echo $before_thumbnail . $thumbnail . $after_thumbnail;
		}
		if($title) {
			echo $before_title . $title . $after_title;
		}

		echo $paragraph;
		echo $after_widget;

	}

  // updating widget replacing old istances with new
	public function update( $new_instance, $old_instance ) {
		// process widget options on save
    $instance = $old_instance;

		$instance['thumbnail'] = strip_tags($new_instance['thumbnail']);
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['paragraph'] = strip_tags($new_instance['paragraph']);


    return $instance;
	}

}

// add function and..
// register short_blogy widget

add_action('widgets_init', function() {
  register_widget('short_blogy');
});
