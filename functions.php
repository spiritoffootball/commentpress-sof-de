<?php /*
================================================================================
CommentPress Spirit of Football Germany Theme Functions
================================================================================
AUTHOR: Christian Wach <needle@haystack.co.uk>
--------------------------------------------------------------------------------
NOTES

Theme amendments and overrides.

This file is loaded before the CommentPress Flat Theme's functions.php file,
so changes and updates can be made here. Most theme-related functions are
pluggable, so if they are defined here, they will override the ones defined in
the CommentPress Flat Theme or common theme functions file.

--------------------------------------------------------------------------------
*/



// set our version here
define( 'COMMENTPRESS_SOF_DE_VERSION', '1.3.7' );

// damn this content width thing
if ( ! isset( $content_width ) ) { $content_width = 760; }

/**
 * Change Default Avatar Size
 */
if ( ! defined( 'BP_AVATAR_THUMB_WIDTH' ) ) {
	define( 'BP_AVATAR_THUMB_WIDTH', 80 );
}

if ( ! defined( 'BP_AVATAR_THUMB_HEIGHT' ) ) {
	define( 'BP_AVATAR_THUMB_HEIGHT', 80 );
}

/*
if ( ! defined( 'BP_AVATAR_FULL_WIDTH' ) ) {
	define( 'BP_AVATAR_FULL_WIDTH', 300 );
}

if ( ! defined( 'BP_AVATAR_FULL_HEIGHT' ) ) {
	define( 'BP_AVATAR_FULL_HEIGHT', 300 );
}
*/



/**
 * OVERRIDE Do we want to show page/post meta?
 *
 * @since 1.3.7
 *
 * @param int $post_id The numeric ID of the post.
 * @return bool $hide_meta True if meta is shown, false if hidden.
 */
function commentpress_get_post_meta_visibility( $post_id ) {

	// always show on posts
	if ( 'post' == get_post_type( $post_id ) ) return true;

	// init hide (hide by default)
	$hide_meta = 'hide';

	// declare access to globals
	global $commentpress_core;

	// if we have the plugin enabled
	if ( is_object( $commentpress_core ) ) {

		// get global hide_meta
		$hide_meta = $commentpress_core->db->option_get( 'cp_page_meta_visibility' );

		// set key
		$key = '_cp_page_meta_visibility';

		// override with local value if the custom field already has one
		if ( get_post_meta( $post_id, $key, true ) != '' ) {
			$hide_meta = get_post_meta( $post_id, $key, true );
		}

	}

	// --<
	return ( $hide_meta == 'show' ) ? true : false;

}



/**
 * Augment the CommentPress Modern Theme setup function.
 *
 * @since 1.0
 */
function commentpress_sof_de_setup() {

	/**
	 * Make theme available for translation.
	 *
	 * Translations can be added to the /languages directory of the child theme.
	 */
	load_child_theme_textdomain(
		'commentpress-sof-de',
		get_stylesheet_directory() . '/languages'
	);

	// create custom filters that mirror 'the_content'
	add_filter( 'commentpress_sof_de_richtext_content', 'wptexturize' );
	add_filter( 'commentpress_sof_de_richtext_content', 'convert_smilies' );
	add_filter( 'commentpress_sof_de_richtext_content', 'convert_chars' );
	add_filter( 'commentpress_sof_de_richtext_content', 'wpautop' );
	add_filter( 'commentpress_sof_de_richtext_content', 'shortcode_unautop' );

	/**
	 * Include Event Organiser compatibility, when plugin is present.
	 * This makes a custom "upcoming events" page available.
	 */
	if ( function_exists( 'eventorganiser_is_event_query' ) ) {
		include( get_stylesheet_directory() . '/includes/compatibility/event-organiser.php' );
	}

	// include custom widgets
	include( get_stylesheet_directory() . '/includes/class-theme-widgets.php' );
	$widgets = new Spirit_Of_Football_Germany_Theme_Widgets;

}

// hook into after_setup_theme
add_action( 'after_setup_theme', 'commentpress_sof_de_setup' );



/**
 * Enqueue child theme styles.
 *
 * Styles can be overridden because the child theme is:
 * 1. enqueueing later than the CommentPress Modern Theme
 * 2. making the file dependent on the CommentPress Modern Theme's stylesheet
 *
 * @since 1.0
 */
function commentpress_sof_de_enqueue_styles() {

	// dequeue parent theme colour styles
	//wp_dequeue_style( 'cp_webfont_lato_css' );
	//wp_dequeue_style( 'cp_colours_css' );

	// add child theme's css file
	wp_enqueue_style(
		'commentpress_sof_de_css',
		get_stylesheet_directory_uri() . '/assets/css/commentpress-sof-de.css',
		array( 'cp_screen_css' ),
		COMMENTPRESS_SOF_DE_VERSION, // version
		'all' // media
	);

	// add child theme's css file
	wp_enqueue_style(
		'commentpress_ifbook_colours_css',
		get_stylesheet_directory_uri() . '/assets/css/commentpress-colours.css',
		array( 'commentpress_sof_de_css' ),
		COMMENTPRESS_SOF_DE_VERSION, // version
		'all' // media
	);
}

// add action for the above
add_action( 'wp_enqueue_scripts', 'commentpress_sof_de_enqueue_styles', 998 );




/**
 * Enqueue child theme scripts.
 *
 * @since 1.0
 */
function commentpress_sof_de_enqueue_scripts() {

	// add our theme javascript
	wp_enqueue_script(
		'commentpress_sof_fitvids_js',
		get_stylesheet_directory_uri() . '/assets/js/jquery.fitvids.js',
		array(),
		COMMENTPRESS_SOF_DE_VERSION
	);

	// add our theme javascript
	wp_enqueue_script(
		'commentpress_sof_de_js',
		get_stylesheet_directory_uri() . '/assets/js/commentpress-sof-de.js',
		array( 'cp_common_js', 'commentpress_sof_fitvids_js' ),
		COMMENTPRESS_SOF_DE_VERSION
	);

	// define local vars
	$vars = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'spinner_url' => get_template_directory_uri() . '/assets/images/interface/ajax-loader.gif',
		'localisation' => array(
			'blah' => __( 'Something', 'buddypress' ),
		),
	);

	// localise
	wp_localize_script( 'commentpress_sof_de_js', 'Commentpress_Poets_Settings', $vars );

}

// add action for the above
add_action( 'wp_enqueue_scripts', 'commentpress_sof_de_enqueue_scripts', 998 );



/**
 * Do not show the "Special Pages" menu.
 *
 * @since 1.0
 *
 * @return false Do not show menu
 */
add_filter( 'cp_content_tab_special_pages_visible', '__return_false' );



/**
 * Wrap header image in link to homepage.
 *
 * @since 1.3.5
 *
 * @param str $image The existing image markup.
 * @return str $image The modified image markup.
 */
function commentpress_sof_de_header_image( $image ) {

	// wrap in link to home
	$image = '<a href="' . home_url() . '">' . $image . '</a>';

	// --<
	return $image;

}

// add filter for the above
add_filter( 'commentpress_header_image', 'commentpress_sof_de_header_image' );



/**
 * Register widget areas for this theme.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @since 1.0
 */
function commentpress_sof_de_register_widget_areas() {

	// define an area where a widget may be placed
	register_sidebar( array(
		'name' => __( 'Homepage Left', 'commentpress-sof-de' ),
		'id' => 'cp-homepage-left',
		'description' => __( 'An optional widget area on the left of the Homepage', 'commentpress-sof-de' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// define an area where a widget may be placed
	register_sidebar( array(
		'name' => __( 'Homepage Right', 'commentpress-sof-de' ),
		'id' => 'cp-homepage-right',
		'description' => __( 'An optional widget area on the right of the Homepage', 'commentpress-sof-de' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// define an area where a widget may be placed
	register_sidebar( array(
		'name' => __( 'Homepage Lower', 'commentpress-sof-de' ),
		'id' => 'cp-homepage-below',
		'description' => __( 'An optional widget area below the left and right widgets on the Homepage', 'commentpress-sof-de' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// BuddyPress Member Homepage - Left
	register_sidebar( array(
		'name'          => esc_html__( 'Member Homepage Left', 'commentpress-sof-de' ),
		'id'            => 'sof-member-front-left',
		'description'   => esc_html__( 'Add widgets to the Member Homepage left column here.', 'commentpress-sof-de' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	// BuddyPress Member Homepage - Right
	register_sidebar( array(
		'name'          => esc_html__( 'Member Homepage Right', 'commentpress-sof-de' ),
		'id'            => 'sof-member-front-right',
		'description'   => esc_html__( 'Add widgets to the Member Homepage right column here.', 'commentpress-sof-de' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}

add_action( 'widgets_init', 'commentpress_sof_de_register_widget_areas' );



/**
 * Enqueue styles to theme the login page.
 *
 * @since 1.0
 */
function commentpress_sof_de_enqueue_login_styles() {

	?>
	<style type="text/css">

		/* page */
		html,
		html body
		{
			background: #e8f8fc;
			background-color: #e8f8fc !important;
		}

		/* logo */
		#login h1 a,
		.login h1 a
		{
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo/sof-logo-commentpress-200.png);
			background-size: 100px;
			width: 100px;
			height: 100px;
			padding-bottom: 1px;
		}

		/* form
		body.login form
		{
			background: #fcfcf8;
		} */

		body.login form .input,
		body.login input[type="text"]
		{
			background: #ceeff8;
		}

		body.login #nav,
		body.login #backtoblog
		{
			text-align: center;
			margin-top: 10px;
		}

		body.login #nav
		{
			margin-top: 16px;
		}

		body.login .message
		{
			border-left: 4px solid #757d12;
		}

		body.login #nav a:hover,
		body.login #backtoblog a:hover,
		body.login h1 a:hover
		{
			color: #555d66;
		}

	</style>
	<?php

	/*
		body.login input[type="text"]:focus,
		body.login input[type="password"]:focus
		{
			border-color: #C1C3A9;
			-webkit-box-shadow: 0 0 2px rgba( 116, 125, 31, 0.8 );
			box-shadow: 0 0 2px rgba( 116, 125, 31, 0.8 );
		}

	*/

}

// add action for the above
add_action( 'login_enqueue_scripts', 'commentpress_sof_de_enqueue_login_styles', 20 );



/**
 * Override auth panel background.
 *
 * @since 1.1
 */
function commentpress_sof_de_admin_head() {

	// match auth panel background to theme
	echo '<style>
		body #wp-auth-check-wrap #wp-auth-check
		{
			background: #e8f8fc;
			background-color: #e8f8fc;
		}
	</style>';

}

// add action for the above
add_action( 'admin_head', 'commentpress_sof_de_admin_head' );



/**
 * Get default image for Open Graph sharing.
 *
 * @since 1.3
 *
 * @param array $media The array of image data.
 * @param int $post_id The ID of the WordPress post. (sometimes missing)
 * @param array $args Additional arguments. (sometimes missing)
 */
function commentpress_sof_de_custom_og_image( $media, $post_id = null, $args = array() ) {

	/*
	error_log( print_r( array(
		'method' => __METHOD__,
		'media' => $media,
		'post_id' => $post_id,
		'args' => $args,
	), true ) );
	*/

	// bail if media is set
	//if ( $media ) return $media;

	// bail if no post ID
	if ( is_null( $post_id ) OR ! is_numeric( $post_id ) ) return $media;

	// get permalink of post
	$permalink = get_permalink( $post_id );

	// get URL of image
	$url = apply_filters( 'jetpack_photon_url', commentpress_sof_de_default_og_image() );

 	// --<
	return array( array(
		'type'  => 'image',
		'from'  => 'custom_fallback',
		'src'   => esc_url( $url ),
		'src_width' => 200,
		'src_height' => 200,
		'href'  => $permalink,
	) );

}

// add filter for the above
add_filter( 'jetpack_images_get_images', 'commentpress_sof_de_custom_og_image', 10, 3 );



/**
 * Set default image for Open Graph sharing.
 *
 * @since 1.3
 *
 * @param str $src Existing default image.
 * @return str $src Modified default image.
 */
function commentpress_sof_de_default_og_image( $src = '' ) {

	// url to theme directory
	$url = trailingslashit( get_stylesheet_directory_uri() );

	// path to file
	$path = 'assets/images/logo/sof-logo-commentpress-270.jpg';

	// --<
	return $url . $path;

}

add_filter( 'jetpack_open_graph_image_default', 'commentpress_sof_de_custom_og_image', 10, 1 );



/**
 * Override title of Latest Comments.
 *
 * @since 1.3.3
 *
 * @param str $src Existing default image.
 * @return str $src Modified default image.
 */
function commentpress_sof_de_latest_comments( $src = '' ) {

	// --<
	return __( 'Latest Comments', 'commentpress-sof-de' );

}

add_filter( 'cp_activity_tab_recent_title_blog', 'commentpress_sof_de_latest_comments', 100, 1 );
add_filter( 'cpmsextras_user_links_new_site_title', 'commentpress_sof_de_latest_comments', 100, 1 );



/**
 * Change the base URL for BP Docs, because we are serving files via ms-files.
 *
 * @since 0.1
 *
 * @param str $att_url Existing attachment URL.
 * @param object $attachment The attachment data object.
 * @return str $att_url Modified attachment URL.
 */
function commentpress_sof_de_bp_docs_attachment_url_base( $att_url, $attachment ) {

	// override, so that BP Docs handles files
	$new_att_base   = basename( get_attached_file( $attachment->ID ) );
	$new_doc_url    = bp_docs_get_doc_link( $attachment->post_parent );
	$new_att_url    = add_query_arg( 'bp-attachment', $new_att_base, $new_doc_url );

	/*
	print_r( array(
		'att_url' => $att_url,
		'attachment' => $attachment,
		'att_base' => $new_att_base,
		'doc_url' => $new_doc_url,
		'att_url new' => $new_att_url,
	) ); die();
	*/

	// --<
	return $new_att_url;

}

// add filter for the above
add_filter( 'bp_docs_attachment_url_base', 'commentpress_sof_de_bp_docs_attachment_url_base', 100, 2 );



