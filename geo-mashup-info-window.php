<?php
/**
 * Geo Mashup Info Window Template.
 *
 * This is the default template for the info window in Geo Mashup maps.
 * See "info-window.php" in the Geo Mashup Custom plugin directory.
 * For styling of the info window, see map-style-default.css.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// A potentially heavy-handed way to remove shortcode-like content.
add_filter( 'the_excerpt', [ 'GeoMashupQuery', 'strip_brackets' ] );

?>
<!-- geo-mashup-info-window.php -->

<div class="locationinfo post-location-info">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<?php

			$multiple_items_class = '';
			if ( $wp_query->post_count > 1 ) {
				$multiple_items_class = ' multiple_items';
			}

			?>

			<div class="location-post<?php echo esc_attr( $multiple_items_class ); ?>">

				<?php

				// Init feature image vars.
				$has_feature_image   = false;
				$feature_image_class = '';
				if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail() ) {
					$has_feature_image   = true;
					$feature_image_class = ' has_feature_image';
				}

				?>

				<div class="post_header<?php echo esc_attr( $feature_image_class ); ?>">

					<?php if ( $has_feature_image ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="feature-link"><?php the_post_thumbnail( 'medium' ); ?></a>
					<?php endif; ?>

					<div class="post_header_text">

						<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<?php /* translators: 1: The author name, 2: The date of publication. */ ?>
						<p class="postname"><?php echo sprintf( esc_html__( 'Written by %1$s on %2$s', 'commentpress-sof-de' ), esc_url( get_the_author_posts_link() ), esc_html( get_the_time( __( 'l, F jS, Y', 'commentpress-sof-de' ) ) ) ); ?></p>

					</div><!-- /.post_header_text -->

				</div><!-- /.post_header -->

				<?php if ( 1 === $wp_query->post_count ) : ?>
					<div class="storycontent">
						<p><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
						<a href="<?php the_permalink(); ?>" title="Read full story" class="more-link"><?php esc_html_e( 'Read full story...', 'commentpress-sof-de' ); ?></a>
					</div>
				<?php else : ?>
					<?php if ( ! $has_feature_image ) : ?>
					<div class="storycontent">
						<a href="<?php the_permalink(); ?>" title="Read full story" class="more-link"><?php esc_html_e( 'Read full story...', 'commentpress-sof-de' ); ?></a>
					</div>
					<?php endif; ?>
				<?php endif; ?>

			</div><!-- /.location-post -->

		<?php endwhile; ?>

	<?php else : ?>

		<h2 class="center"><?php esc_html_e( 'Not Found', 'commentpress-sof-de' ); ?></h2>
		<p class="center"><?php esc_html_e( 'Sorry, but you are looking for something that isn’t here.', 'commentpress-sof-de' ); ?></p>

	<?php endif; ?>

</div>
