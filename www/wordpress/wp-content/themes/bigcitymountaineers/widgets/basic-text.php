<?php
// another function TEST for multiple widget to page -------------------------------------------

/**
 * Adds Custom Form widget. TEST TESt
 */
class Basic_Text extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct( //need to check details ... YES
			'basic_text', // Base ID
			__( 'Basic Text For(M)', 'text_domain' ), // Name ** UPDATE NAME HERE text_domain+>tutplustextdomain
			array(
        'classname' => 'basic_text',
        'description' => __( 'Basic text widget example and see..', 'text_domain')
      )
		);
    load_plugin_textdomain('text_domain', false, basename(dirname(__FILE__)).'/languages');
	} //constract function done before here

	/**
	 * Front-end display of widget.
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
    extract($args);

    $title = apply_filters('widget_title', $instance['title']);
    $message = $instance['message'];

    echo $before_widget;

    if($title) {
      echo $before_title . $title . $after_title;
    }

    echo $message;
    echo $after_widget;

	}

	public function form( $instance ) {
		// creates the back-end form
    $title = esc_attr($instance['title(M)']);
    $message = esc_attr($instance['message(M)']);
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title');?>"><?php _e('Title(w):'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
      type="text" value="<?php echo $title; ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Simple (M)'); ?></label>
      <textarea class="widefat" row="16" cols="20" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>">
        <?php echo $message; ?></textarea>
    </p>
    <?php
	}

  // updating widget replacing old istances with new
	public function update( $new_instance, $old_instance ) {
		// process widget options on save
    $instance = $old_instance;

    $instance['title'] = strip_tags($new_instance['title']);
    $instance['message'] = strip_tags($new_instance['message']);

    return $instance;
	}

}

// add function and..
// register basic_form widget
/*function register_basic_text_widget() {
    register_widget( 'basic_text' );
}
add_action( 'widgets_init', 'register_basic_text_widget' ); */

add_action('widgets_init', function() {
  register_widget('basic_text');
});
