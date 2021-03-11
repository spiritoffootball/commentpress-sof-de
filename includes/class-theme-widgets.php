<?php

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

		// register hooks
		$this->register_hooks();

	}



	/**
	 * Register WordPress hooks.
	 *
	 * @since 1.3.7
	 */
	public function register_hooks() {

		// register widget
		add_action( 'widgets_init', [ $this, 'register_widgets' ] );

	}



	/**
	 * Register widgets for this component.
	 *
	 * @since 1.3.7
	 */
	public function register_widgets() {

		// include widgets
		require_once get_stylesheet_directory() . '/assets/widgets/latest-ball-post-widget.php';

		// register widgets
		register_widget( 'SOF_Widget_Latest_Ball_Post' );

	}



} // class ends



