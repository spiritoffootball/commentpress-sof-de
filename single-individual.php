<?php
/**
 * Single Individual Template.
 *
 * @since 1.4.6
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>
<!-- single.php -->
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

					<div id="content" class="content-wrapper">
						<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>">

							<?php if ( ! commentpress_has_feature_image() ) : ?>
								<h2 class="post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php endif; ?>

							<?php $image = get_field( 'picture' ); ?>
							<div class="individual-image">
								<?php if ( ! empty( $image ) ) : ?>
									<img class="avatar" src="<?php echo $image['sizes']['large']; ?>" width="<?php echo ( $image['sizes']['large-width'] / 2 ); ?>" height="<?php echo ( $image['sizes']['large-height'] / 2 ); ?>">
								<?php else : ?>
									<img class="avatar" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/misc/default-avatar.png" width="320" height="320" />
								<?php endif; ?>
							</div>

							<?php $job_title = get_field( 'job_title_de' ); ?>
							<?php if ( ! empty( $job_title ) ) : ?>
								<div class="individual-job-title">
									<?php echo $job_title; ?>
								</div>
							<?php endif; ?>

							<?php $about = get_field( 'summary_de' ); ?>
							<?php if ( ! empty( $about ) ) : ?>
								<div class="individual-about">
									<?php echo $about; ?>
								</div>
							<?php endif; ?>

							<?php $email = get_field( 'email' ); ?>
							<?php if ( ! empty( $email ) ) : ?>
								<div class="individual-email">
									<?php echo str_replace( '@', '[at]', $email ); ?>
								</div>
							<?php endif; ?>

							<?php
							$social_links = [];
							foreach ( [ 'facebook', 'instagram', 'twitter', 'tiktok', 'snapchat', 'youtube', 'vimeo', 'tumblr', 'pinterest', 'github', 'wordpress' ] as $selector ) :
								$field = get_field( $selector );
								if ( ! empty( $field ) ) :
									$social_links[ $selector ] = $field;
								endif;
							endforeach;
							?>

							<?php if ( ! empty( $social_links ) ) : ?>
								<div class="jetpack_widget_social_icons individual-social-links">
									<ul class="jetpack-social-widget-list size-large">
									<?php foreach ( $social_links as $selector => $social_link ) : ?>
										<li class="jetpack-social-widget-item individual-social-link individual-<?php echo $selector; ?>">
											<a href="<?php echo $social_link; ?>" target="_self">
												<span class="screen-reader-text"><?php echo ucfirst( $selector ); ?></span>
												<svg class="icon icon-<?php echo $selector; ?>" aria-hidden="true" role="presentation">
													<use href="#icon-<?php echo $selector; ?>" xlink:href="#icon-<?php echo $selector; ?>"></use>
												</svg>
											</a>
										</li>
									<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>

							<?php $website = get_field( 'website' ); ?>
							<?php if ( ! empty( $website ) ) : ?>
								<div class="individual-website">
									<a href="<?php echo $website; ?>"><?php esc_html_e( 'Website', 'commentpress-sof-de' ); ?></a>
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
			<div id="page_wrapper">
				<div id="content">
					<div class="post">

						<h2 class="post_title"><?php esc_html_e( 'Post Not Found', 'commentpress-sof-de' ); ?></h2>
						<p><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'commentpress-sof-de' ); ?></p>
						<?php get_search_form(); ?>

					</div><!-- /post -->
				</div><!-- /content -->
			</div><!-- /page_wrapper -->
		</div><!-- /main_wrapper -->

	<?php endif; ?>

</div><!-- /wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
