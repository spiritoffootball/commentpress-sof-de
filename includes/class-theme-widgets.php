<?php
/**
 * Theme Widgets Class.
 *
 * Handles initialisation of theme-specific Widgets.
 *
 * @since 1.3.7
 * @package CommentPress_SOF
 */

/**
 * Theme Widgets Class.
 *
 * A class that encapsulates initialisation of theme-specific Widgets.
 *
 * @since 1.3.7
 *
 * @package WordPress
 * @subpackage Spirit_Of_Football_Germany
 */
class Spirit_Of_Football_Germany_Theme_Widgets {

	/**
	 * Constructor.
	 *
	 * @since 1.3.7
	 */
	public function __construct() {

		// Register hooks.
		$this->register_hooks();

	}

	/**
	 * Register WordPress hooks.
	 *
	 * @since 1.3.7
	 */
	public function register_hooks() {

		// Register widget.
		add_action( 'widgets_init', [ $this, 'register_widgets' ] );

	}

	/**
	 * Register widgets for this component.
	 *
	 * @since 1.3.7
	 */
	public function register_widgets() {

		// Include widgets.
		require_once get_stylesheet_directory() . '/assets/widgets/latest-ball-post-widget.php';

		// Register widgets.
		register_widget( 'SOF_Widget_Latest_Ball_Post' );

	}

}
