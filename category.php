<?php
/**
 * Category Template.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

get_header();

?><!-- category.php (child) -->
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

					<?php if ( is_category() ) : ?>
						<h3 class="post_title"><?php echo single_cat_title( '', false ); ?></h3>
					<?php elseif ( is_tag() ) : ?>
						<h3 class="post_title"><?php echo sprintf( __( 'Posts Tagged &#8216;%s&#8217;', 'commentpress-sof-de' ), single_cat_title( '', false ) ); ?></h3>
					<?php elseif ( isset( $_GET['paged'] ) && ! empty( $_GET['paged'] ) ) : ?>
						<h3 class="post_title"><?php esc_html_e( 'Archives', 'commentpress-sof-de' ); ?></h3>
					<?php endif; ?>

					<?php if ( is_category() ) : ?>
						<?php $category_description = category_description(); ?>
						<?php if ( ! empty( $category_description ) ) : ?>
							<div class="category-description">
								<?php echo $category_description; ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>

					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>

						<div class="search_result">

							<?php commentpress_get_feature_image(); ?>

							<?php if ( ! commentpress_has_feature_image() ) : ?>

								<h3 id="post-<?php the_ID(); ?>">
									<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to', 'commentpress-sof-de' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
								</h3>

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

							<div class="search_excerpt">
								<?php the_excerpt(); ?>
							</div>

							<p class="search_meta"><?php the_tags( __( 'Tags: ', 'commentpress-sof-de' ), ', ', '<br />' ); ?> <?php esc_html_e( 'Posted in', 'commentpress-sof-de' ); ?> <?php the_category( ', ' ); ?> | <?php edit_post_link( __( 'Edit', 'commentpress-sof-de' ), '', ' | ' ); ?>  <?php comments_popup_link( __( 'No Comments &#187;', 'commentpress-sof-de' ), __( '1 Comment &#187;', 'commentpress-sof-de' ), __( '% Comments &#187;', 'commentpress-sof-de' ) ); ?></p>

						</div><!-- /search_result -->

					<?php endwhile; ?>

				<?php else : ?>

					<h2 class="post_title"><?php esc_html_e( 'Not Found', 'commentpress-sof-de' ); ?></h2>

					<p><?php esc_html_e( 'Sorry, but you are looking for something that isn’t here.', 'commentpress-sof-de' ); ?></p>

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
