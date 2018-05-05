<?php /*
================================================================================
Geo Mashup Info Window Template
================================================================================
AUTHOR: Christian Wach <needle@haystack.co.uk>
--------------------------------------------------------------------------------
NOTES

This is the default template for the info window in Geo Mashup maps.
See "info-window.php" in the Geo Mashup Custom plugin directory.
For styling of the info window, see map-style-default.css.

--------------------------------------------------------------------------------
*/

// A potentially heavy-handed way to remove shortcode-like content
add_filter( 'the_excerpt', array( 'GeoMashupQuery', 'strip_brackets' ) );

?>

<!-- geo-mashup-info-window.php -->

<div class="locationinfo post-location-info">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php

			$multiple_items_class = '';
			if ( $wp_query->post_count > 1 ) {
				$multiple_items_class = ' multiple_items';
			}

			?>

			<div class="location-post<?php echo $multiple_items_class; ?>">

				<?php

				// init feature image vars
				$has_feature_image = false;
				$feature_image_class = '';
				if ( function_exists( 'has_post_thumbnail' ) AND has_post_thumbnail() ) {
					$has_feature_image = true;
					$feature_image_class = ' has_feature_image';
				}

				?>

				<div class="post_header<?php echo $feature_image_class; ?>">

					<?php

					// when we have a feature image...
					if ( $has_feature_image ) {
						?><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="feature-link"><?php
						the_post_thumbnail( 'medium' );
						?></a><?php
					}

					?>

					<div class="post_header_text">

						<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<p class="postname">Written by <?php the_author_posts_link(); ?> on <?php the_time( 'l, F jS, Y' ) ?></p>

					</div><!-- /.post_header_text -->

				</div><!-- /.post_header -->

				<?php if ( $wp_query->post_count == 1 ) : ?>
					<div class="storycontent">
						<p><?php echo strip_tags( get_the_excerpt() ); ?></p>
						<a href="<?php the_permalink() ?>" title="Read full story" class="more-link"><?php _e( 'Read full story...', 'commentpress-sof-de' ); ?></a>
					</div>
				<?php else: ?>
					<?php if ( ! $has_feature_image ) : ?>
					<div class="storycontent">
						<a href="<?php the_permalink() ?>" title="Read full story" class="more-link"><?php _e( 'Read full story...', 'commentpress-sof-de' ); ?></a>
					</div>
					<?php endif; ?>
				<?php endif; ?>

			</div><!-- /.location-post -->

		<?php endwhile; ?>

	<?php else : ?>

		<h2 class="center"><?php _e( 'Not Found', 'commentpress-sof-de' ); ?></h2>
		<p class="center"><?php _e( 'Sorry, but you are looking for something that isn’t here.', 'commentpress-sof-de' ); ?></p>

	<?php endif; ?>

</div>



