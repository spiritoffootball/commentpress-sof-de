<?php
/**
 * Template Name: People
 *
 * The template for displaying the People page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @since 1.4.6
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>
<!-- page-people.php -->

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
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>">

							<?php if ( ! commentpress_has_feature_image() ) : ?>
								<h2 class="post_title"<?php commentpress_post_title_visibility( get_the_ID() ); ?>><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php endif; ?>

							<?php $board_loop = locate_template( 'template-parts/loop-individuals-board.php' ); ?>
							<?php if ( $board_loop ) : ?>
								<?php load_template( $board_loop ); ?>
							<?php endif; ?>

							<?php $backoffice_loop = locate_template( 'template-parts/loop-individuals-backoffice.php' ); ?>
							<?php if ( $backoffice_loop ) : ?>
								<?php load_template( $backoffice_loop ); ?>
							<?php endif; ?>

							<?php $projektmanagerinnen_loop = locate_template( 'template-parts/loop-individuals-projektmanagerinnen.php' ); ?>
							<?php if ( $projektmanagerinnen_loop ) : ?>
								<?php load_template( $projektmanagerinnen_loop ); ?>
							<?php endif; ?>

							<?php the_content(); ?>

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

<?php get_sidebar(); ?>

<?php get_footer(); ?>
