<?php
/**
 * Event Category Template.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

get_header();

?><!-- taxonomy-event-category.php -->
<div id="wrapper">

	<div id="main_wrapper" class="clearfix">

		<div id="page_wrapper">

			<?php

			// Try to locate template.
			$template = locate_template( 'assets/templates/page_navigation.php' );

			/**
			 * Filter the template path.
			 *
			 * @since 1.0
			 *
			 * @param str $template The path to the template,
			 */
			$cp_page_navigation = apply_filters( 'cp_template_page_navigation', $template );

			// Load it if we find it.
			if ( $cp_page_navigation != '' ) {
				load_template( $cp_page_navigation, false );
			}

			?>

			<div id="content" class="clearfix">

				<div class="post">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h3 class="page-title"><?php printf( __( 'Event Category: %s', 'commentpress-sof-de' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h3>
							<?php

							// If the category has a description display it.
							$category_description = category_description();
							if ( ! empty( $category_description ) ) {
								echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
							}

							?>
						</header>

						<div class="event-loop">

							<?php while ( have_posts() ) : ?>
								<?php the_post(); ?>

								<div class="search_result">

									<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to', 'commentpress-sof-de' ); ?> <?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'thumbnail', [ 'style' => 'float: left; margin: 0 12px 12px 0;' ] ); ?><?php the_title(); ?></a></h3>

									<?php
									$cp_meta_visibility = ' style="display: none;"';
									if ( commentpress_get_post_meta_visibility( get_the_ID() ) ) {
										$cp_meta_visibility = '';
									}
									?>

									<div class="search_meta"<?php echo $cp_meta_visibility; ?>>
										<?php commentpress_echo_post_meta(); ?>
									</div>

									<?php
									/*
									 * Format date/time according to whether its an all day event.
									 *
									 * Use microdata:
									 *
									 * @see http://support.google.com/webmasters/bin/answer.py?hl=en&answer=176035
									 */
									if ( eo_is_all_day() ) {
										$format = 'd F Y';
										$microformat = 'Y-m-d';
									} else {
										$format = 'd F Y ' . get_option( 'time_format' );
										$microformat = 'c';
									}
									?>

									<time itemprop="startDate" datetime="<?php eo_the_start( $microformat ); ?>"><?php eo_the_start( $format ); ?></time>

									<?php echo eo_get_event_meta_list(); ?>

									<?php the_excerpt(); ?>

									<p class="search_meta"><?php the_terms( get_the_ID(), 'event-tag', __( 'Tags: ', 'commentpress-sof-de' ), ', ', '<br />' ); ?> <?php esc_html_e( 'Posted in', 'commentpress-sof-de' ); ?> <?php the_terms( get_the_ID(), 'event-category', '', ', ' ); ?> | <?php edit_post_link( __( 'Edit', 'commentpress-sof-de' ), '', ' | ' ); ?>  <?php comments_popup_link( __( 'No Comments &#187;', 'commentpress-sof-de' ), __( '1 Comment &#187;', 'commentpress-sof-de' ), __( '% Comments &#187;', 'commentpress-sof-de' ) ); ?></p>

								</div><!-- /search_result -->

							<?php endwhile; ?>

						</div><!-- /event-loop -->

					<?php else : ?>

						<h2 class="post_title"><?php esc_html_e( 'Nothing Found', 'commentpress-sof-de' ); ?></h2>

						<p><?php esc_html_e( 'Apologies, but no results were found for the requested category.', 'commentpress-sof-de' ); ?></p>

						<?php get_search_form(); ?>

					<?php endif; ?>

				</div><!-- /post -->

			</div><!-- /content -->

			<div class="page_nav_lower">
				<?php

				// Include page_navigation again.
				if ( $cp_page_navigation != '' ) {
					load_template( $cp_page_navigation, false );
				}

				?>
			</div><!-- /page_nav_lower -->

		</div><!-- /page_wrapper -->

	</div><!-- /main_wrapper -->

</div><!-- /wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
