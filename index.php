<?php
/**
 * Default Template.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

get_header();

?><!-- index.php -->
<div id="wrapper">

	<div id="main_wrapper" class="clearfix">

		<div id="page_wrapper">

			<?php commentpress_page_navigation_template(); ?>

			<div id="content" class="clearfix">

				<div class="post">

					<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : ?>
							<?php the_post(); ?>

							<div class="search_result">

								<?php commentpress_get_feature_image(); ?>

								<?php if ( ! commentpress_has_feature_image() ) : ?>
									<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to', 'commentpress-sof-de' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

									<div class="search_meta"<?php commentpress_post_meta_visibility( get_the_ID() ); ?>>
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

						<h2 class="post_title"><?php esc_html_e( 'No blog posts found', 'commentpress-sof-de' ); ?></h2>

						<p><?php esc_html_e( 'There are no blog posts yet.', 'commentpress-sof-de' ); ?>
							<?php if ( is_user_logged_in() ) : ?>
								<a href="<?php admin_url(); ?>"><?php esc_html_e( 'Go to your dashboard to add one.', 'commentpress-sof-de' ); ?></a>
							<?php endif; ?></p>

						<p><?php esc_html_e( 'If you were looking for something that hasn’t been found, try using the search form below.', 'commentpress-sof-de' ); ?></p>

						<?php get_search_form(); ?>

					<?php endif; ?>

				</div><!-- /post -->

			</div><!-- /content -->

			<div class="page_nav_lower">
				<?php commentpress_page_navigation_template(); ?>
			</div><!-- /page_nav_lower -->

		</div><!-- /page_wrapper -->

	</div><!-- /main_wrapper -->

</div><!-- /wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
