<?php
/**
 * SOF Latest Ball Post Widget.
 *
 * @since 1.3.7
 *
 * @package WordPress
 * @subpackage Spirit_Of_Football_Germany
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Core class used to implement a "Latest Ball Post" widget.
 *
 * @since 1.3.7
 *
 * @see WP_Widget
 */
class SOF_Widget_Latest_Ball_Post extends WP_Widget {

	/**
	 * Constructor registers widget with WordPress.
	 *
	 * @since 1.3.7
	 */
	public function __construct() {

		// Use the class `widget_recent_entries` to inherit WordPress Recent Posts widget styling.
		$widget_ops = [
			'classname' => 'widget_latest_ball_post',
			'description' => __( 'Displays the most recent "Daily Ballblog" that the visitor can read.', 'commentpress-sof-de' ),
		];

		parent::__construct(
			'widget_latest_ball_post',
			_x( 'Latest Ball Post', 'widget name', 'commentpress-sof-de' ),
			$widget_ops
		);

	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @since 0.1
	 *
	 * @param array $args Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param array $instance An array of settings for this widget instance.
	 */
	public function widget( $args, $instance ) {

		// Define args for query.
		$query_args = [
			'post_type' => 'post',
			'no_found_rows' => true,
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'tax_query' => [
				[
					'taxonomy' => 'category',
					'field' => 'term_id',
					'terms' => 674,
				],
			],
		];

		// Do query.
		$posts = new WP_Query( $query_args );

		// Did we get any results?
		if ( $posts->have_posts() ) :

			// Get filtered title.
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			// Show widget prefix.
			echo ( isset( $args['before_widget'] ) ? $args['before_widget'] : '' );

			// Show title if there is one.
			if ( ! empty( $title ) ) {
				echo ( isset( $args['before_title'] ) ? $args['before_title'] : '' );
				echo $title;
				echo ( isset( $args['after_title'] ) ? $args['after_title'] : '' );
			}

			// Remove feature image switcher if present.
			global $feature_image_switcher;
			if ( isset( $feature_image_switcher ) ) {
				remove_filter( 'commentpress_get_feature_image', [ $feature_image_switcher, 'get_button' ], 20, 2 );
			}

			// Filter the title to prevent it being commentable.
			add_filter( 'commentpress_get_feature_image_title', [ $this, 'filter_title' ], 10, 2 );

			while ( $posts->have_posts() ) : ?>
				<?php $posts->the_post(); ?>

				<div class="latest_ball_post">

					<?php commentpress_get_feature_image(); ?>

					<?php if ( ! commentpress_has_feature_image() ) : ?>
						<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to', 'commentpress-sof-de' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

						<div class="search_meta">
							<?php commentpress_echo_post_meta(); ?>
						</div>
					<?php endif; ?>

					<div class="search_excerpt">
						<?php the_excerpt(); ?>
					</div>

					<p class="search_meta"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php esc_html_e( 'Read more...', 'commentpress-sof-de' ); ?></a></p>

				</div><!-- /latest_ball_post -->

				<?php

			endwhile;

			// Remove title filter.
			remove_filter( 'commentpress_get_feature_image_title', [ $this, 'filter_title' ], 10 );

			// Show widget suffix.
			echo ( isset( $args['after_widget'] ) ? $args['after_widget'] : '' );

			// Reset the post globals as this query will have stomped on it.
			wp_reset_postdata();

			// Re-hook feature image switcher if present.
			if ( isset( $feature_image_switcher ) ) {
				add_filter( 'commentpress_get_feature_image', [ $feature_image_switcher, 'get_button' ], 20, 2 );
			}

		// End check for posts.
		endif;

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @since 1.3.7
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		// Get title.
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Latest Ballblog Post', 'commentpress-sof-de' );
		}

		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'commentpress-sof-de' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<?php

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @since 1.3.7
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * @return array $instance Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		// Never lose a value.
		$instance = wp_parse_args( $new_instance, $old_instance );

		// --<
		return $instance;

	}

	/**
	 * Filter the page/post title when there is a feature image.
	 *
	 * @since 1.3.10
	 *
	 * @param str $title The page title.
	 * @param WP_Post $post The current WordPress post object.
	 * @return str $title The modified page title.
	 */
	public function filter_title( $title, $post ) {

		// Remove commentable class.
		$title = str_replace( 'class="post_title page_title"', 'class="widget_title"', $title );
		$title = str_replace( 'class="post_title"', 'class="widget_title"', $title );

		// --<
		return $title;

	}

}
