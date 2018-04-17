<?php get_header(); ?>



<!-- archive-event.php -->

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

<?php if ( have_posts() ) : ?>

	<!-- Page header, display tag title-->
	<header class="page-header">
		<h1 class="page-title"><?php
			printf( __( 'Terminschlagwort: %s', 'eventorganiser' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		?></h1>

	<!-- If the tag has a description display it-->
		<?php
			$tag_description = category_description();
			if ( ! empty( $tag_description ) )
				echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $tag_description . '</div>' );
		?>
	</header>

	<?php /* Start the Loop */ ?>
	<div class="event-loop">

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="search_result">

			<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'commentpress-core' ); ?> <?php the_title_attribute(); ?>"><?php
					//If it has one, display the thumbnail
					the_post_thumbnail('thumbnail', array('style'=>'float:left;margin: 0 12px 12px 0;'));
				?><?php the_title(); ?></a></h3>

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

			<?php

			//Format date/time according to whether its an all day event.
			//Use microdata http://support.google.com/webmasters/bin/answer.py?hl=en&answer=176035
			if( eo_is_all_day() ){
				$format = 'd F Y';
				$microformat = 'Y-m-d';
			}else{
				$format = 'd F Y '.get_option('time_format');
				$microformat = 'c';
			}

			?><time itemprop="startDate" datetime="<?php eo_the_start($microformat); ?>"><?php eo_the_start($format); ?></time>

			<!-- Display event meta list -->
			<?php echo eo_get_event_meta_list(); ?>

			<?php the_excerpt() ?>

			<p class="search_meta"><?php the_terms( get_the_ID(), 'event-tag', __( 'Tags: ', 'commentpress-core' ), ', ', '<br />' ); ?> <?php _e( 'Posted in', 'commentpress-core' ); ?> <?php the_terms( get_the_ID(), 'event-category', '', ', ' ); ?> | <?php edit_post_link( __( 'Edit', 'commentpress-core' ), '', ' | ' ); ?>  <?php comments_popup_link( __( 'No Comments &#187;', 'commentpress-core' ), __( '1 Comment &#187;', 'commentpress-core' ), __( '% Comments &#187;', 'commentpress-core' ) ); ?></p>

		</div><!-- /search_result -->

	<?php endwhile; ?><!--The Loop ends-->

	</div>

<?php else : ?>

	<!-- If there are no events -->
	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Nothing Found', 'eventorganiser' ); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<p><?php _e( 'Apologies, but no events were found for the requested tag. ', 'eventorganiser' ); ?></p>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->

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