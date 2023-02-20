<?php
/**
 * Event Category Template.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>
<!-- taxonomy-event-tag.php -->
<div id="wrapper">
	<div id="main_wrapper" class="clearfix">
		<div id="page_wrapper">

			<?php commentpress_page_navigation_template(); ?>

			<div id="content" class="clearfix">
				<div class="post">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title"><?php printf( __( 'Event Tag: %s', 'commentpress-sof-de' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

							<?php

							// If the tag has a description display it.
							$tag_description = category_description();
							if ( ! empty( $tag_description ) ) {
								echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
							}

							?>
						</header>

						<div class="event-loop">

							<?php while ( have_posts() ) : ?>

								<?php the_post(); ?>

								<div class="search_result">

									<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to', 'commentpress-sof-de' ); ?> <?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'thumbnail', [ 'style' => 'float:left; margin: 0 12px 12px 0;' ] ); ?><?php the_title(); ?></a></h3>

									<div class="search_meta"<?php commentpress_post_meta_visibility( get_the_ID() ); ?>>
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

							<?php endwhile; ?><!--The Loop ends-->

						</div>

					<?php else : ?>

						<h2 class="post_title"><?php esc_html_e( 'Nothing Found', 'commentpress-sof-de' ); ?></h2>
						<p><?php esc_html_e( 'Apologies, but no results were found for the requested tag.', 'commentpress-sof-de' ); ?></p>
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
