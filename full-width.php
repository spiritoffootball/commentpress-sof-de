<?php
/**
 * Template Name: Full Width
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>
<!-- full-width.php -->

<div id="wrapper">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : ?>

			<?php the_post(); ?>

			<div id="main_wrapper" class="clearfix">
				<div id="page_wrapper">

					<?php commentpress_get_feature_image(); ?>

					<?php if ( ! commentpress_has_feature_image() ) : ?>
						<?php commentpress_page_navigation_template(); ?>
					<?php endif; ?>

					<div id="content" class="content">
						<div class="post<?php echo esc_attr( commentpress_get_post_css_override( get_the_ID() ) ); ?>" id="post-<?php the_ID(); ?>">

							<?php if ( ! commentpress_has_feature_image() ) : ?>

								<?php /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
								<h2 class="post_title"<?php commentpress_post_title_visibility( get_the_ID() ); ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

								<?php /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
								<div class="search_meta"<?php commentpress_post_meta_visibility( get_the_ID() ); ?>>
									<?php commentpress_echo_post_meta(); ?>
								</div>

							<?php endif; ?>

							<?php the_content(); ?>

							<?php echo commentpress_multipager(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>

							<?php /* Test for "Post Tags and Categories for Pages" plugin. */ ?>
							<?php if ( class_exists( 'PTCFP' ) ) : ?>
								<p class="search_meta">
									<?php the_tags( __( 'Tags: ', 'commentpress-sof-de' ), ', ', '<br />' ); ?> <?php esc_html_e( 'Posted in', 'commentpress-sof-de' ); ?> <?php the_category( ', ' ); ?>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( commentpress_get_page_number( get_the_ID() ) ) ) : ?>
								<div class="running_header_bottom">
									<?php commentpress_page_number( get_the_ID() ); ?>
								</div>
							<?php endif; ?>

						</div><!-- /post -->
					</div><!-- /content -->

					<div class="page_nav_lower">
						<?php commentpress_page_navigation_template(); ?>
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
