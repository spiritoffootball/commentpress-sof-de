<?php get_header(); ?>



<!-- archive.php ev -->

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

	<?php //$post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h3 class="post_title"><?php echo single_cat_title( '', false ); ?></h3>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h3 class="post_title"><?php echo sprintf( __( 'Posts Tagged &#8216;%s&#8217;', 'commentpress-core' ), single_cat_title( '', false ) ) ?></h3>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h3 class="post_title"><?php _e( 'Archive for', 'commentpress-core' ); ?> <?php the_time( __( 'F jS, Y', 'commentpress-core' ) ); ?></h3>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h3 class="post_title"><?php _e( 'Archive for', 'commentpress-core' ); ?> <?php the_time( __( 'F, Y', 'commentpress-core' ) ); ?></h3>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h3 class="post_title"><?php _e( 'Archive for', 'commentpress-core' ); ?> <?php the_time( __( 'Y', 'commentpress-core' ) ); ?></h3>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h3 class="post_title"><?php _e( 'Author Archive', 'commentpress-core' ); ?></h3>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h3 class="post_title"><?php _e( 'Archives', 'commentpress-core' ); ?></h3>
	<?php } ?>

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

	<h2 class="post_title"><?php _e( 'Not Found', 'commentpress-core' ); ?></h2>

	<p><?php _e( "Sorry, but you are looking for something that isn't here.", 'commentpress-core' ); ?></p>

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
