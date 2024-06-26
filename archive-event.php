<?php
/**
 * Event Archive Template.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?><!-- archive-event.php -->
<div id="wrapper">
	<div id="main_wrapper" class="clearfix">
		<div id="page_wrapper">

			<?php

			// Set default link names.
			$previous_title = __( 'Earlier Events', 'commentpress-sof-de' );
			$next_title     = __( 'Later Events', 'commentpress-sof-de' );

			$nl = get_next_posts_link( $next_title );
			$pl = get_previous_posts_link( $previous_title );

			?>

			<?php if ( ! empty( $nl ) || ! empty( $pl ) ) : ?>
				<div class="page_navigation">
					<ul class="blog_navigation">
						<?php if ( ! empty( $nl ) ) : ?>
							<li class="alignright"><?php echo $nl; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></li>
						<?php endif; ?>
						<?php if ( ! empty( $pl ) ) : ?>
							<li class="alignleft"><?php echo $pl; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>

			<div id="content" class="clearfix">
				<div class="post">

					<?php if ( have_posts() ) : ?>

						<h3 class="post_title">
							<?php
							if ( eo_is_event_archive( 'day' ) ) {
								// Viewing date archive.
								esc_html_e( 'Events: ', 'commentpress-sof-de' ) . ' ' . eo_get_event_archive_date( 'jS F Y' );
							} elseif ( eo_is_event_archive( 'month' ) ) {
								// Viewing month archive.
								esc_html_e( 'Events: ', 'commentpress-sof-de' ) . ' ' . eo_get_event_archive_date( 'F Y' );
							} elseif ( eo_is_event_archive( 'year' ) ) {
								// Viewing year archive.
								esc_html_e( 'Events: ', 'commentpress-sof-de' ) . ' ' . eo_get_event_archive_date( 'Y' );
							} elseif ( 'upcoming-events' === get_query_var( 'commentpress_sof_de' ) ) {
								// Viewing upcoming events archive.
								esc_html_e( 'Upcoming Events', 'commentpress-sof-de' );
							} else {
								esc_html_e( 'Events', 'commentpress-sof-de' );
							}
							?>
						</h3>

						<div class="event-loop">

							<?php while ( have_posts() ) : ?>

								<?php the_post(); ?>

								<div class="search_result">

									<?php commentpress_get_feature_image(); ?>

									<?php if ( ! commentpress_has_feature_image() ) : ?>
										<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to', 'commentpress-sof-de' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<?php endif; ?>

									<div class="search_meta"<?php commentpress_post_meta_visibility( get_the_ID() ); ?>>
										<?php commentpress_echo_post_meta(); ?>
									</div>

									<?php

									/*
									 * Format date/time according to whether its an all day event.
									 *
									 * Use microdata:
									 *
									 * @see https://developers.google.com/search/docs/appearance/structured-data/intro-structured-data
									 */
									if ( eo_is_all_day() ) {
										$format      = 'd F Y';
										$microformat = 'Y-m-d';
									} else {
										$format      = 'd F Y ' . get_option( 'time_format' );
										$microformat = 'c';
									}

									?>

									<time itemprop="startDate" datetime="<?php eo_the_start( $microformat ); ?>"><?php eo_the_start( $format ); ?></time>

									<?php echo eo_get_event_meta_list(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>

									<?php the_excerpt(); ?>

									<p class="search_meta"><?php the_tags( __( 'Tags: ', 'commentpress-sof-de' ), ', ', '<br />' ); ?> <?php esc_html_e( 'Posted in', 'commentpress-sof-de' ); ?> <?php the_category( ', ' ); ?> | <?php edit_post_link( __( 'Edit', 'commentpress-sof-de' ), '', ' | ' ); ?>  <?php comments_popup_link( __( 'No Comments &#187;', 'commentpress-sof-de' ), __( '1 Comment &#187;', 'commentpress-sof-de' ), __( '% Comments &#187;', 'commentpress-sof-de' ) ); ?></p>

								</div><!-- /archive_item -->

							<?php endwhile; ?>

						</div>

					<?php else : ?>

						<h2 class="post_title"><?php esc_html_e( 'Not Found', 'commentpress-sof-de' ); ?></h2>
						<p><?php esc_html_e( 'Apologies, but no results were found for the requested archive.', 'commentpress-sof-de' ); ?></p>
						<?php get_search_form(); ?>

					<?php endif; ?>

				</div><!-- /post -->
			</div><!-- /content -->

			<div class="page_nav_lower">
				<?php if ( ! empty( $nl ) || ! empty( $pl ) ) : ?>
					<div class="page_navigation">
						<ul class="blog_navigation">
							<?php if ( ! empty( $nl ) ) : ?>
								<li class="alignright"><?php echo $nl; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></li>
							<?php endif; ?>
							<?php if ( ! empty( $pl ) ) : ?>
								<li class="alignleft"><?php echo $pl; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></li>
							<?php endif; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div><!-- /page_nav_lower -->

		</div><!-- /page_wrapper -->
	</div><!-- /main_wrapper -->
</div><!-- /wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
