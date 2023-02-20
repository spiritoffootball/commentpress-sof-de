<?php
/**
 * Event Venue Template.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>
<!-- taxonomy-event-venue.php -->
<div id="wrapper">
	<div id="main_wrapper" class="clearfix">
		<div id="page_wrapper">

			<?php commentpress_page_navigation_template(); ?>

			<div id="content" class="clearfix">
				<div class="post">

					<header class="page-header">

						<?php $venue_id = get_queried_object_id(); ?>
						<h1 class="page-title"><?php printf( __( 'Events at: %s', 'commentpress-sof-de' ), '<span>' . eo_get_venue_name( $venue_id ) . '</span>' ); ?></h1>

						<?php $venue_description = eo_get_venue_description( $venue_id ); ?>
						<?php if ( $venue_description ) : ?>
							<div class="venue-archive-meta"><?php echo $venue_description; ?></div>
						<?php endif; ?>

						<!-- Display the venue map. If you specify a class, ensure that class has height/width dimensions -->
						<?php echo eo_get_venue_map( $venue_id, [ 'width' => '100%' ] ); ?>

					</header><!-- end header -->

					<?php if ( have_posts() ) : ?>

						<div class="event-loop">

							<?php while ( have_posts() ) : ?>

								<?php the_post(); ?>

								<div class="search_result">

									<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr_e( 'Permanent Link to', 'commentpress-sof-de' ); ?> <?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'thumbnail', [ 'style' => 'float: left; margin: 0 12px 12px 0;' ] ); ?><?php the_title(); ?></a></h3>

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

							<?php endwhile; ?>

						</div>

					<?php else : ?>

						<!-- If there are no events -->
						<article id="post-0" class="post no-results not-found">
							<header class="entry-header">
								<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'commentpress-sof-de' ); ?></h1>
							</header><!-- .entry-header -->
							<div class="entry-content">
								<p><?php esc_html_e( 'Apologies, but no events were found for the requested venue.', 'commentpress-sof-de' ); ?></p>
							</div><!-- .entry-content -->
						</article><!-- #post-0 -->

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
