<?php
/**
 * Template Name: Full Width
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

get_header();

?><!-- full-width.php -->

<div id="wrapper">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>

			<div id="main_wrapper" class="clearfix<?php echo commentpress_theme_tabs_class_get(); ?>">

				<?php commentpress_theme_tabs_render(); ?>

				<div id="page_wrapper"<?php echo commentpress_theme_tabs_classes_get(); ?>>

					<?php commentpress_get_feature_image(); ?>

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

					<div id="content" class="content workflow-wrapper">

						<div class="post<?php echo commentpress_get_post_css_override( get_the_ID() ); ?>" id="post-<?php the_ID(); ?>">

							<?php if ( ! commentpress_has_feature_image() ) : ?>

								<?php
								$cp_title_visibility = ' style="display: none;"';
								if ( commentpress_get_post_title_visibility( get_the_ID() ) ) {
									$cp_title_visibility = '';
								}
								?>

								<h2 class="post_title"<?php echo $cp_title_visibility; ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

								<?php
								$cp_meta_visibility = ' style="display: none;"';
								if ( commentpress_get_post_meta_visibility( get_the_ID() ) ) {
									$cp_meta_visibility = '';
								}
								?>

								<div class="search_meta"<?php echo $cp_meta_visibility; ?>>
									<?php commentpress_echo_post_meta(); ?>
								</div>

							<?php endif; ?>

							<?php

							global $more;
							$more = true;
							the_content( '' );

							?>

							<?php
							/*
							 * NOTE: Comment permalinks are filtered if the comment is not on the first page
							 * in a multipage post... see: commentpress_multipage_comment_link in functions.php
							 */
							echo commentpress_multipager();
							?>

							<?php
							// Test for "Post Tags and Categories for Pages" plugin.
							if ( class_exists( 'PTCFP' ) ) {
								?>
								<p class="search_meta"><?php the_tags( __( 'Tags: ', 'commentpress-sof-de' ), ', ', '<br />' ); ?> <?php esc_html_e( 'Posted in', 'commentpress-sof-de' ); ?> <?php the_category( ', ' ); ?></p>
								<?php
							}
							?>

							<?php if ( is_object( $commentpress_core ) ) : ?>

								<?php

								// Get page num.
								$num = $commentpress_core->nav->get_page_number( get_the_ID() );
								if ( $num ) {

									// Make lowercase if Roman.
									if ( ! is_numeric( $num ) ) {
										$num = strtolower( $num );
									}

									// Wrap number.
									$element = '<span class="page_num_bottom">' . $num . '</span>';

									?>

									<div class="running_header_bottom">
										<?php echo sprintf( __( 'Page %s', 'commentpress-sof-de' ), $element ); ?>
									</div>

								<?php } ?>

							<?php endif; ?>

						</div><!-- /post -->

					</div><!-- /content -->

					<?php commentpress_theme_tabs_content_render(); ?>

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

		<?php endwhile; ?>

	<?php else : ?>

		<div id="main_wrapper" class="clearfix">
			<div id="page_wrapper" class="page_wrapper">
				<div id="content" class="content">
					<div class="post">

						<h2 class="post_title"><?php esc_html_e( 'Page Not Found', 'commentpress-sof-de' ); ?></h2>
						<p><?php esc_html_e( 'Sorry, but you are looking for something that isn’t here.', 'commentpress-sof-de' ); ?></p>
						<?php get_search_form(); ?>

					</div><!-- /post -->
				</div><!-- /content -->
			</div><!-- /page_wrapper -->
		</div><!-- /main_wrapper -->

	<?php endif; ?>

</div><!-- /wrapper -->

<?php get_footer(); ?>
