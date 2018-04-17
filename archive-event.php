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



<?php if (have_posts()) : ?>

	<h3 class="post_title">
	<?php
	if ( eo_is_event_archive( 'day' ) ) {
		//Viewing date archive
		echo __( 'Events: ','eventorganiser' ).' '.eo_get_event_archive_date( 'jS F Y' );
	} elseif ( eo_is_event_archive( 'month' ) ) {
		//Viewing month archive
		echo __( 'Events: ','eventorganiser' ).' '.eo_get_event_archive_date( 'F Y' );
	} elseif ( eo_is_event_archive( 'year' ) ) {
		//Viewing year archive
		echo __( 'Events: ','eventorganiser' ).' '.eo_get_event_archive_date( 'Y' );
	} elseif( 'upcoming-events' == get_query_var( 'commentpress_sof_de' ) ) {
		//Viewing upcoming events archive
		echo __('Upcoming Events','commentpress-sof-de');
	} else {
		_e( 'Events', 'eventorganiser' );
	}
	?>
	</h3>

	<div class="event-loop">

	<?php while (have_posts()) : the_post(); ?>

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

			<p class="search_meta"><?php the_tags( __( 'Tags: ', 'commentpress-core' ), ', ', '<br />' ); ?> <?php _e( 'Posted in', 'commentpress-core' ); ?> <?php the_category( ', ' ); ?> | <?php edit_post_link( __( 'Edit', 'commentpress-core' ), '', ' | ' ); ?>  <?php comments_popup_link( __( 'No Comments &#187;', 'commentpress-core' ), __( '1 Comment &#187;', 'commentpress-core' ), __( '% Comments &#187;', 'commentpress-core' ) ); ?></p>

		</div><!-- /archive_item -->

	<?php endwhile; ?>

	</div>



<?php else : ?>

	<h2 class="post_title"><?php _e( 'Not Found', 'commentpress-core' ); ?></h2>

	<p><?php _e( 'Apologies, but no results were found for the requested archive.', 'eventorganiser' ); ?></p>

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