<?php
/**
 * Theme Functions.
 *
 * This file is loaded before the CommentPress Flat Theme's functions.php file,
 * so changes and updates can be made here. Most theme-related functions are
 * pluggable, so if they are defined here, they will override the ones defined in
 * the CommentPress Flat Theme or common theme functions file.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Set our version here.
define( 'COMMENTPRESS_SOF_DE_VERSION', '1.4.7a' );

// Damn this content width thing.
if ( ! isset( $content_width ) ) {
	$content_width = 760;
}

/**
 * Change Default Avatar Size.
 *
 * @since 1.3.11
 */
if ( ! defined( 'BP_AVATAR_THUMB_WIDTH' ) ) {
	define( 'BP_AVATAR_THUMB_WIDTH', 100 );
}

if ( ! defined( 'BP_AVATAR_THUMB_HEIGHT' ) ) {
	define( 'BP_AVATAR_THUMB_HEIGHT', 100 );
}

if ( ! defined( 'BP_AVATAR_FULL_WIDTH' ) ) {
	define( 'BP_AVATAR_FULL_WIDTH', 300 );
}

if ( ! defined( 'BP_AVATAR_FULL_HEIGHT' ) ) {
	define( 'BP_AVATAR_FULL_HEIGHT', 300 );
}



/**
 * Support ACF Google Maps.
 *
 * @since 1.4.4
 */
function commentpress_sof_acf_init() {
	if ( defined( 'SOF_GOOGLE_API_KEY' ) ) {
		acf_update_setting( 'google_api_key', SOF_GOOGLE_API_KEY );
	}
}

// Add action for the above.
add_action( 'acf/init', 'commentpress_sof_acf_init' );



/**
 * Filters the members loop avatar.
 *
 * @since 1.3.11
 *
 * @param string       $value Formatted HTML <img> element, or raw avatar URL based on $html arg.
 * @param array|string $args See {@link bp_get_member_avatar()}.
 * @return int $value Modified HTML <img> element, or raw avatar URL based on $html arg.
 */
function commentpress_avatar_filter( $value, $args ) {

	if ( empty( $args['type'] ) || ( ! empty( $args['type'] ) && 'thumb' === $args['type'] ) ) {
		if ( ! is_array( $args ) ) {
			$args = [];
		}
		$args['type'] = 'full';
		return bp_get_member_avatar( $args );
	}

	// --<
	return $value;

}

// Add filter for the above.
add_filter( 'bp_member_avatar', 'commentpress_avatar_filter', 10, 2 );



/**
 * Filters the group members loop avatar.
 *
 * @since 1.3.11
 *
 * @param string       $value Formatted HTML <img> element, or raw avatar URL based on $html arg.
 * @param array|string $args See {@link bp_get_member_avatar()}.
 * @return int $value Modified HTML <img> element, or raw avatar URL based on $html arg.
 */
function commentpress_avatar_group_member_filter( $value, $args ) {

	// Set type manually.
	if ( empty( $args['type'] ) || 'thumb' === $args['type'] ) {
		$args['type'] = 'full';
		return bp_core_fetch_avatar( $args );
	}

	// --<
	return $value;

}

// Add filter for the above.
add_filter( 'bp_get_group_member_avatar_thumb', 'commentpress_avatar_group_member_filter', 10, 2 );



/**
 * Filters the group loop avatar.
 *
 * @since 1.3.11
 *
 * @param string       $value Formatted HTML <img> element, or raw avatar URL based on $html arg.
 * @param array|string $args See {@link bp_get_member_avatar()}.
 * @return int $value Modified HTML <img> element, or raw avatar URL based on $html arg.
 */
function commentpress_avatar_group_filter( $value, $args ) {

	// Set type manually.
	if ( ! empty( $args['type'] ) && $args['type'] == 'thumb' ) {
		global $groups_template;
		if ( ! empty( $groups_template->group->id ) ) {
			$args['type'] = 'full';
			$args['item_id'] = $groups_template->group->id;
			$args['avatar_dir'] = 'group-avatars';
			$args['object'] = 'group';
			return bp_core_fetch_avatar( $args );
		}
	}

	// --<
	return $value;

}

// Add filter for the above.
add_filter( 'bp_get_group_avatar', 'commentpress_avatar_group_filter', 10, 2 );



/**
 * Do we want to show Page/Post meta?
 *
 * NOTE: This is an override of the built-in CommentPress function that always shows meta
 * on Posts.
 *
 * @since 1.3.7
 *
 * @param int $post_id The numeric ID of the post.
 * @return bool $show_meta True if meta is shown, false if hidden.
 */
function commentpress_get_post_meta_visibility( $post_id ) {

	// Always show on posts.
	if ( 'post' === get_post_type( $post_id ) ) {
		return true;
	}

	// Hide by default.
	$show_meta = 'hide';

	// Use setting from core if present.
	$core = commentpress_core();
	if ( ! empty( $core ) ) {
		$show_meta = $core->entry->single->entry_show_meta_get( $post_id );
	}

	// --<
	return 'show' === $show_meta ? true : false;

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

	// Create custom filters that mirror 'the_content'.
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
		include get_stylesheet_directory() . '/includes/compatibility/event-organiser.php';
	}

	// Include custom widgets.
	include get_stylesheet_directory() . '/includes/class-theme-widgets.php';
	$widgets = new Spirit_Of_Football_Germany_Theme_Widgets();

	// Allow shortcodes in term descriptions.
	add_filter( 'term_description', 'do_shortcode' );

}

// Add action for the above.
add_action( 'after_setup_theme', 'commentpress_sof_de_setup' );



if ( ! function_exists( 'commentpress_sof_de_site_icon_meta_tags' ) ) :

	/**
	 * Filters the site icon meta tags.
	 *
	 * To make this work, upload both black *and* white logos and leave the white
	 * logo in place. This function will replace the favicons with the black versions.
	 *
	 * @since 1.3.15
	 *
	 * @param array $meta_tags The existing Site Icon meta elements.
	 * @return array $meta_tags The modified Site Icon meta elements.
	 */
	function commentpress_sof_de_site_icon_meta_tags( $meta_tags ) {

		// Bail if none.
		if ( empty( $meta_tags ) ) {
			return $meta_tags;
		}

		// Replace white with black icons.
		foreach ( $meta_tags as $key => $meta_tag ) {
			if ( false !== strpos( $meta_tag, 'rel="icon"' ) ) {
				$meta_tags[ $key ] = str_replace( 'white', 'black', $meta_tag );
			}
		}

		// --<
		return $meta_tags;

	}

endif;

/*
// Add filter for the above.
add_filter( 'site_icon_meta_tags', 'commentpress_sof_de_site_icon_meta_tags', 10 );
*/



/**
 * Enqueue child theme styles.
 *
 * Styles can be overridden because the child theme is:
 *
 * 1. enqueueing later than the CommentPress Modern Theme
 * 2. making the file dependent on the CommentPress Modern Theme's stylesheet
 *
 * @since 1.0
 */
function commentpress_sof_de_enqueue_styles() {

	/*
	// Dequeue parent theme colour styles.
	wp_dequeue_style( 'cp_webfont_lato_css' );
	wp_dequeue_style( 'cp_colours_css' );
	*/

	// Add child theme's CSS file.
	wp_enqueue_style(
		'commentpress_sof_de_css',
		get_stylesheet_directory_uri() . '/assets/css/commentpress-sof-de.css',
		[ 'cp_screen_css' ],
		COMMENTPRESS_SOF_DE_VERSION, // Version.
		'all' // Media.
	);

	// Add child theme's CSS file.
	wp_enqueue_style(
		'commentpress_ifbook_colours_css',
		get_stylesheet_directory_uri() . '/assets/css/commentpress-colours.css',
		[ 'commentpress_sof_de_css' ],
		COMMENTPRESS_SOF_DE_VERSION, // Version.
		'all' // Media.
	);
}

// Add action for the above.
add_action( 'wp_enqueue_scripts', 'commentpress_sof_de_enqueue_styles', 998 );



/**
 * Enqueue child theme scripts.
 *
 * @since 1.0
 */
function commentpress_sof_de_enqueue_scripts() {

	// Add our theme script.
	wp_enqueue_script(
		'commentpress_sof_js',
		get_stylesheet_directory_uri() . '/assets/js/commentpress-sof-de.js',
		[ 'cp_common_js' ],
		COMMENTPRESS_SOF_DE_VERSION,
		true
	);

	// Define local vars.
	$vars = [
		'ajax_url'     => admin_url( 'admin-ajax.php' ),
		'spinner_url'  => get_template_directory_uri() . '/assets/images/interface/ajax-loader.gif',
		'localisation' => [
			'blah' => __( 'Something', 'commentpress-sof-de' ),
		],
	];

	// Localise the WordPress way.
	wp_localize_script( 'commentpress_sof_js', 'CommentPress_SOF_Settings', $vars );

}

// Add action for the above.
add_action( 'wp_enqueue_scripts', 'commentpress_sof_de_enqueue_scripts', 998 );



/**
 * Do not show the "Special Pages" menu.
 *
 * @since 1.0
 *
 * @return false Do not show menu.
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

	// Wrap in link to home.
	$image = '<a href="' . home_url() . '">' . $image . '</a>';

	// --<
	return $image;

}

// Add filter for the above.
add_filter( 'commentpress_header_image', 'commentpress_sof_de_header_image' );



/**
 * Register widget areas for this theme.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @since 1.0
 */
function commentpress_sof_de_register_widget_areas() {

	// Define an area where a widget may be placed.
	$args = [
		'name'          => __( 'Homepage Left', 'commentpress-sof-de' ),
		'id'            => 'cp-homepage-left',
		'description'   => __( 'An optional widget area on the left of the Homepage', 'commentpress-sof-de' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	];
	register_sidebar( $args );

	// Define an area where a widget may be placed.
	$args = [
		'name'          => __( 'Homepage Right', 'commentpress-sof-de' ),
		'id'            => 'cp-homepage-right',
		'description'   => __( 'An optional widget area on the right of the Homepage', 'commentpress-sof-de' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	];
	register_sidebar( $args );

	// Define an area where a widget may be placed.
	$args = [
		'name'          => __( 'Homepage Lower', 'commentpress-sof-de' ),
		'id'            => 'cp-homepage-below',
		'description'   => __( 'An optional widget area below the left and right widgets on the Homepage', 'commentpress-sof-de' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	];
	register_sidebar( $args );

	// BuddyPress Member Homepage - Left.
	$args = [
		'name'          => esc_html__( 'Member Homepage Left', 'commentpress-sof-de' ),
		'id'            => 'sof-member-front-left',
		'description'   => esc_html__( 'Add widgets to the Member Homepage left column here.', 'commentpress-sof-de' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	];
	register_sidebar( $args );

	// BuddyPress Member Homepage - Right.
	$args = [
		'name'          => esc_html__( 'Member Homepage Right', 'commentpress-sof-de' ),
		'id'            => 'sof-member-front-right',
		'description'   => esc_html__( 'Add widgets to the Member Homepage right column here.', 'commentpress-sof-de' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	];
	register_sidebar( $args );

}

// Add action for the above.
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
			background-image: url(<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/logo/sof-logo-commentpress-200.png);
			background-size: 100px;
			width: 100px;
			height: 100px;
			padding-bottom: 1px;
		}

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

}

// Add action for the above.
add_action( 'login_enqueue_scripts', 'commentpress_sof_de_enqueue_login_styles', 20 );



/**
 * Override auth panel background.
 *
 * @since 1.1
 */
function commentpress_sof_de_admin_head() {

	// Match auth panel background to theme.
	echo '<style>
		body #wp-auth-check-wrap #wp-auth-check
		{
			background: #e8f8fc;
			background-color: #e8f8fc;
		}
	</style>';

}

// Add action for the above.
add_action( 'admin_head', 'commentpress_sof_de_admin_head' );



/**
 * Get default image for Open Graph sharing.
 *
 * @since 1.3
 *
 * @param array $media The array of image data.
 * @param int   $post_id The ID of the WordPress post -sometimes missing.
 * @param array $args Additional arguments - sometimes missing.
 */
function commentpress_sof_de_custom_og_image( $media, $post_id = null, $args = [] ) {

	/*
	// Bail if media is already set.
	if ( $media ) {
		return $media;
	}
	*/

	// Bail if no Post ID.
	if ( is_null( $post_id ) || ! is_numeric( $post_id ) ) {
		return $media;
	}

	// Get permalink of Post.
	$permalink = get_permalink( $post_id );

	// Get URL of image.
	$url = apply_filters( 'jetpack_photon_url', commentpress_sof_de_default_og_image() );

	// Build nested array.
	$nested = [
		'type'       => 'image',
		'from'       => 'custom_fallback',
		'src'        => esc_url( $url ),
		'src_width'  => 200,
		'src_height' => 200,
		'href'       => $permalink,
	];

	// --<
	return [ $nested ];

}

// Add filter for the above.
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

	// URL to theme directory.
	$url = trailingslashit( get_stylesheet_directory_uri() );

	// Path to file.
	$path = 'assets/images/logo/sof-logo-commentpress-270.jpg';

	// --<
	return $url . $path;

}

// Add filter for the above.
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
	return __( 'Latest Comments', 'commentpress-sof-de' );
}

add_filter( 'cp_activity_tab_recent_title_blog', 'commentpress_sof_de_latest_comments', 100, 1 );
add_filter( 'cpmsextras_user_links_new_site_title', 'commentpress_sof_de_latest_comments', 100, 1 );



/**
 * Change the base URL for BP Docs, because we are serving files via ms-files.
 *
 * @since 0.1
 *
 * @param str    $att_url Existing attachment URL.
 * @param object $attachment The attachment data object.
 * @return str $att_url Modified attachment URL.
 */
function commentpress_sof_de_bp_docs_attachment_url_base( $att_url, $attachment ) {

	// Override, so that BP Docs handles files.
	$new_att_base = basename( get_attached_file( $attachment->ID ) );
	$new_doc_url  = bp_docs_get_doc_link( $attachment->post_parent );
	$new_att_url  = add_query_arg( 'bp-attachment', $new_att_base, $new_doc_url );

	// --<
	return $new_att_url;

}

// Add filter for the above.
add_filter( 'bp_docs_attachment_url_base', 'commentpress_sof_de_bp_docs_attachment_url_base', 100, 2 );



/**
 * Override the template for a single Rendez Vous.
 *
 * @since 1.3.18
 *
 * @param str $template Existing template path.
 * @return str $template Modified template path.
 */
function commentpress_sof_de_rendez_vous_template( $template ) {

	// Bail if 404.
	if ( is_404() ) {
		return $template;
	}

	// Is this a single Rendez Vous?
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( ! empty( $_GET['rdv'] ) && (int) $_GET['rdv'] > 0 ) {

		// Switch to full page template.
		$template = locate_template( [ 'full-width.php' ] );

		// Add body class filter.
		add_filter( 'body_class', 'commentpress_sof_de_rendez_vous_body_class' );

	}

	// --<
	return $template;

}

// Add filter for the above.
add_filter( 'template_include', 'commentpress_sof_de_rendez_vous_template', 100 );



/**
 * Override the body class for a single Rendez Vous.
 *
 * @since 1.3.18
 *
 * @param array $classes The existing template path.
 * @return str $template The modified template path.
 */
function commentpress_sof_de_rendez_vous_body_class( $classes ) {

	// Bail if 404.
	if ( is_404() ) {
		return $classes;
	}

	// Init default template key.
	$key_to_replace = null;

	// Find key for "page-template-default".
	if ( ! empty( $classes ) ) {
		foreach ( $classes as $key => $class ) {
			if ( 'page-template-default' === $class ) {
				$key_to_replace = $key;
			}
		}
	}

	// If we find it, replace with ours.
	if ( ! empty( $key_to_replace ) ) {
		$classes[ $key ] = 'page-template-full-width';
	}

	// --<
	return $classes;

}



/**
 * Add Blog ID to the body class.
 *
 * @since 1.4.1
 *
 * @param array $classes The existing template path.
 * @return str $template The modified template path.
 */
function commentpress_sof_de_blog_id_body_class( $classes ) {

	// Add Blog ID.
	$classes[] = 'wp-blog-id-' . get_current_blog_id();

	// --<
	return $classes;

}

// Add filter for the above.
add_filter( 'body_class', 'commentpress_sof_de_blog_id_body_class' );
