<?php get_header(); ?>



<!-- index.php -->

<div id="wrapper">



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<?php

// first try to locate using WP method
$cp_page_navigation = apply_filters(
	'cp_template_page_navigation',
	locate_template( 'assets/templates/page_navigation.php' )
);

// load it if we find it
if ( $cp_page_navigation != '' ) load_template( $cp_page_navigation, false );

?>



<div id="content" class="clearfix">

<div class="post">



<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

		<div class="search_result">

			<?php commentpress_get_feature_image(); ?>

			<?php if ( ! commentpress_has_feature_image() ) : ?>
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'commentpress-core' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

				<?php

				// default to hidden
				$cp_meta_visibility = ' style="display: none;"';

				// override if we've elected to show the meta
				if ( commentpress_get_post_meta_visibility( get_the_ID() ) ) {
					$cp_meta_visibility = '';
				}

				?>
				<div class="search_meta"<?php echo $cp_meta_visibility; ?>>
					<?php commentpress_echo_post_meta(); ?>
				</div>
			<?php endif; ?>

			<div class="search_excerpt">
				<?php the_excerpt() ?>
			</div>

			<p class="search_meta"><?php the_tags( __( 'Tags: ', 'commentpress-core' ), ', ', '<br />'); ?> <?php _e( 'Posted in', 'commentpress-core' ); ?> <?php the_category( ', ' ) ?> | <?php edit_post_link( __( 'Edit', 'commentpress-core' ), '', ' | '); ?>  <?php comments_popup_link( __( 'No Comments &#187;', 'commentpress-core' ), __( '1 Comment &#187;', 'commentpress-core' ), __( '% Comments &#187;', 'commentpress-core' ) ); ?></p>

		</div><!-- /search_result -->

	<?php endwhile; ?>

<?php else : ?>

		<h2 class="post_title"><?php _e( 'No blog posts found', 'commentpress-core' ); ?></h2>

		<p><?php _e( 'There are no blog posts yet.', 'commentpress-core' ); ?> <?php

		// if logged in
		if ( is_user_logged_in() ) {

			// add a suggestion
			?> <a href="<?php admin_url(); ?>"><?php _e( 'Go to your dashboard to add one.', 'commentpress-core' ); ?></a><?php

		}

		?></p>

		<p><?php _e( "If you were looking for something that hasn't been found, try using the search form below.", 'commentpress-core' ); ?></p>

		<?php get_search_form(); ?>

<?php endif; ?>



</div><!-- /post -->

</div><!-- /content -->



<div class="page_nav_lower">
<?php

// include page_navigation again
if ( $cp_page_navigation != '' ) load_template( $cp_page_navigation, false );

?>
</div><!-- /page_nav_lower -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>