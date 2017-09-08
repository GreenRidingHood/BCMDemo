<?php
// Add SVG as allowable file upload type
function bigcitymountaineers_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'bigcitymountaineers_mime_types');

/**
 * Enqueue scripts and styles
 */
function bigcitymountaineers_scripts() {
    /* Big City Mountaineers Custom Theme CSS */
	wp_enqueue_style( 'bigcitymountaineers-style', get_template_directory_uri() . '/assets/css/site.min.css', NULL, filemtime( get_stylesheet_directory() . '/assets/css/site.min.css'));

	/* Big City Mountaineers Custom Theme Javascript */
	wp_deregister_script( 'wp-embed' ); // Remove WordPress oEmbed feature.

	if(is_front_page()) { // Remove Unneeded libariries from the homepage
		wp_deregister_style( 'formidable' ); // Formidable CSS
		// wp_deregister_script( 'jquery' ); // Remove WordPress jquery version and use our own.
	}

    wp_enqueue_script( 'bigcitymountaineers-script', get_template_directory_uri() . '/assets/js/site.min.js', array(), filemtime( get_stylesheet_directory() . '/assets/js/site.min.js'), true );
}
add_action( 'wp_enqueue_scripts', 'bigcitymountaineers_scripts' );

if (defined('WPSEO_VERSION')){
	add_action('get_header',function (){ ob_start(function ($o){
		return preg_replace('/^<!--.*?[Y]oast.*?-->$/mi','',$o); });
	});
	add_action('wp_head',function (){ ob_end_flush(); }, 999);
}

/**
 * Simplify admin menus to only include what we are using
 */
function remove_menus(){
	//  remove_menu_page( 'index.php' );                  //Dashboard
	remove_menu_page( 'edit.php' );                   //Posts
	//  remove_menu_page( 'upload.php' );                 //Media
	//  remove_menu_page( 'edit.php?post_type=page' );    //Pages
	remove_menu_page( 'edit-comments.php' );          //Comments
	//  remove_menu_page( 'themes.php' );                 //Appearance
	//  remove_menu_page( 'plugins.php' );                //Plugins
	//  remove_menu_page( 'users.php' );                  //Users
	//  remove_menu_page( 'tools.php' );                  //Tools
	//  remove_menu_page( 'options-general.php' );        //Settings
}
add_action( 'admin_menu', 'remove_menus' );

/**
 * Enable Post Thumbnail theme support
 */
add_theme_support( 'post-thumbnails' );

/**
 * Disable WordPress built-in emojicons
 */
function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	// filter to remove TinyMCE emojis
	//add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

/**
 * Disable Miscellaneous WordPress Header Includes
 */
function bigcitymountaineers_remove_head_links() {
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 ); // Outputs the REST API link tag into page header.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 ); // Adds oEmbed discovery links in the website.
	remove_action( 'wp_head', 'wp_resource_hints', 2 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head'); // Adds a “shortlink” into your document head
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
}
add_action('init', 'bigcitymountaineers_remove_head_links');

/**
 * Title Tags Support
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'theme_slug_render_title' );
}
function bigcitymountaineers_after_setup_theme() {
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'bigcitymountaineers_after_setup_theme' );

/**
 * Add custom menu support
 */
add_theme_support( 'menus' );

function register_bigcitymountaineers_menus() {
  register_nav_menu('main-menu',__( 'Main Menu' ));
  register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'register_bigcitymountaineers_menus' );

/**
 * Admin Editor Stylesheet
 */
add_editor_style( 'custom-editor-style.css' );



/**
 * Custom Site Logo
 */
add_theme_support( 'custom-logo' );
add_theme_support( 'custom-logo', array(
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
) );



// foo widget test ----------------------------------------------------------------------

/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			esc_html__( 'Foo Widget', 'text_domain' ), // Name ** UPDATE NAME HERE
			array( 'description' => esc_html__( 'A Foo Widget', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo esc_html__( 'Hello, World!', 'text_domain' );

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} // class Foo_Widget

// add function

// register Foo_Widget widget
function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );



// another function TEST for multiple widget to page -------------------------------------------

/**
 * Adds Custom Form widget. TEST TESt
 */
class basic_text extends WP_Widget {

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

add_action('widgets_init', function()) {
  register_widget('basic_text');
});
