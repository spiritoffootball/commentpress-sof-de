<?php get_header(); ?>



<!-- single-event.php -->

<div id="wrapper">



<?php if (have_posts()) : while (have_posts()) : the_post();

// access post
global $post;



// init class values
$tabs_class = '';
$tabs_classes = '';

// init workflow items
$original = '';
$literal = '';

// do we have workflow?
if ( is_object( $commentpress_core ) ) {

	// get workflow
	$_workflow = $commentpress_core->db->option_get( 'cp_blog_workflow' );

	// is it enabled?
	if ( $_workflow == '1' ) {

		// okay, let's add our tabs

		// set key
		$key = '_cp_original_text';

		// if the custom field already has a value
		if ( get_post_meta( $post->ID, $key, true ) != '' ) {

			// get it
			$original = get_post_meta( $post->ID, $key, true );

		}

		// set key
		$key = '_cp_literal_translation';

		// if the custom field already has a value
		if ( get_post_meta( $post->ID, $key, true ) != '' ) {

			// get it
			$literal = get_post_meta( $post->ID, $key, true );

		}

		// did we get either type of workflow content?
		if ( $literal != '' OR $original != '' ) {

			// override tabs class
			$tabs_class = 'with-content-tabs';

			// override tabs classes
			$tabs_classes = ' class="' . $tabs_class . '"';

			// prefix with space
			$tabs_class = ' ' . $tabs_class;

		}

	}

}


?>



<div id="main_wrapper" class="clearfix<?php echo $tabs_class; ?>">



<?php

// did we get tabs?
if ( $tabs_class != '' ) {

	// did we get either type of workflow content?
	if ( $literal != '' OR $original != '' ) {

	?>
	<ul id="content-tabs">
		<li id="content_header" class="default-content-tab"><h2><a href="#content"><?php
			echo apply_filters(
				'commentpress_content_tab_content',
				__( 'Content', 'commentpress-core' )
			);
		?></a></h2></li>
		<?php if ( $literal != '' ) { ?>
		<li id="literal_header"><h2><a href="#literal"><?php
			echo apply_filters(
				'commentpress_content_tab_literal',
				__( 'Literal', 'commentpress-core' )
			);
		?></a></h2></li>
		<?php } ?>
		<?php if ( $original != '' ) { ?>
		<li id="original_header"><h2><a href="#original"><?php
			echo apply_filters(
				'commentpress_content_tab_original',
				__( 'Original', 'commentpress-core' )
			);
		?></a></h2></li>
		<?php } ?>
	</ul>
	<?php

	}

}

?>



<div id="page_wrapper"<?php echo $tabs_classes; ?>>



<?php

// show feature image
commentpress_get_feature_image();

?>



<?php

// first try to locate using WP method
$cp_page_navigation = apply_filters(
	'cp_template_page_navigation',
	locate_template( 'assets/templates/page_navigation.php' )
);

// load it if we find it
if ( $cp_page_navigation != '' ) load_template( $cp_page_navigation, false );

?>



<div id="content" class="workflow-wrapper">



<div class="post<?php echo commentpress_get_post_css_override( get_the_ID() ); ?>" id="post-<?php the_ID(); ?>">



<?php

// do we have a featured image?
if ( ! commentpress_has_feature_image() ) {

	?><h2 class="post_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

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

}

?>


<?php commentpress_get_post_version_info( $post ); ?>



<?php if ( eo_get_venue() && eo_venue_has_latlng( eo_get_venue() ) ) : ?>
	<div class="eo-event-venue-mapx">
		<?php echo eo_get_venue_map( eo_get_venue(), array( 'width' => '100%' ) ); ?>
	</div>
<?php endif; ?>



<div class="eventorganiser-event-meta">

	<hr>

	<!-- Event details -->
	<h4><?php _e( 'Event Details', 'eventorganiser' ); ?></h4>

	<!-- Is event recurring or a single event -->
	<?php if ( eo_recurs() ) :?>
		<!-- Event recurs - is there a next occurrence? -->
		<?php $next = eo_get_next_occurrence( eo_get_event_datetime_format() );?>

		<?php if ( $next ) : ?>
			<!-- If the event is occurring again in the future, display the date -->
			<?php printf( '<p>' . __( 'This event is running from %1$s until %2$s. It is next occurring on %3$s', 'eventorganiser' ) . '</p>', eo_get_schedule_start( 'j F Y' ), eo_get_schedule_last( 'j F Y' ), $next );?>

		<?php else : ?>
			<!-- Otherwise the event has finished (no more occurrences) -->
			<?php printf( '<p>' . __( 'This event finished on %s', 'eventorganiser' ) . '</p>', eo_get_schedule_last( 'd F Y', '' ) );?>
		<?php endif; ?>
	<?php endif; ?>

	<ul class="eo-event-meta">

		<?php if ( ! eo_recurs() ) { ?>
			<!-- Single event -->
			<li><strong><?php esc_html_e( 'Date', 'eventorganiser' );?>:</strong> <?php echo eo_format_event_occurrence();?></li>
		<?php } ?>

		<?php if ( eo_get_venue() ) {
			$tax = get_taxonomy( 'event-venue' ); ?>
			<li><strong><?php echo esc_html( $tax->labels->singular_name ) ?>:</strong> <a href="<?php eo_venue_link(); ?>"> <?php eo_venue_name(); ?></a></li>
		<?php } ?>

		<?php if ( get_the_terms( get_the_ID(), 'event-category' ) && ! is_wp_error( get_the_terms( get_the_ID(), 'event-category' ) ) ) { ?>
			<li><strong><?php esc_html_e( 'Categories', 'eventorganiser' ); ?>:</strong> <?php echo get_the_term_list( get_the_ID(),'event-category', '', ', ', '' ); ?></li>
		<?php } ?>

		<?php if ( get_the_terms( get_the_ID(), 'event-tag' ) && ! is_wp_error( get_the_terms( get_the_ID(), 'event-tag' ) ) ) { ?>
			<li><strong><?php esc_html_e( 'Tags', 'eventorganiser' ); ?>:</strong> <?php echo get_the_term_list( get_the_ID(), 'event-tag', '', ', ', '' ); ?></li>
		<?php } ?>

		<?php if ( eo_recurs() ) {
				//Event recurs - display dates.
				$upcoming = new WP_Query(array(
					'post_type'         => 'event',
					'event_start_after' => 'today',
					'posts_per_page'    => -1,
					'event_series'      => get_the_ID(),
					'group_events_by'   => 'occurrence',
				));

				if ( $upcoming->have_posts() ) : ?>

					<li><strong><?php _e( 'Upcoming Dates', 'eventorganiser' ); ?>:</strong>
						<ul class="eo-upcoming-dates">
							<?php
							while ( $upcoming->have_posts() ) {
								$upcoming->the_post();
								echo '<li>' . eo_format_event_occurrence() . '</li>';
							};
							?>
						</ul>
					</li>

					<?php
					wp_reset_postdata();
					//With the ID 'eo-upcoming-dates', JS will hide all but the next 5 dates, with options to show more.
					wp_enqueue_script( 'eo_front' );
					?>
				<?php endif; ?>
		<?php } ?>

		<?php do_action( 'eventorganiser_additional_event_meta' ) ?>

	</ul>

	<div style="clear:both"></div>

	<hr>

</div><!-- .entry-meta -->



<?php global $more; $more = true; the_content(''); ?>



<?php

// NOTE: Comment permalinks are filtered if the comment is not on the first page
// in a multipage post... see: commentpress_multipage_comment_link in functions.php
echo commentpress_multipager();

?>



<p class="postmetadata"><?php

	// define RSS text
	$rss_text = __( 'RSS 2.0', 'commentpress-core' );

	// construct RSS link
	$rss_link = '<a href="' . esc_url( get_post_comments_feed_link() ) . '">' . $rss_text . '</a>';

	// show text
	echo sprintf(
		__( 'You can follow any comments on this entry through the %s feed.', 'commentpress-core' ),
		$rss_link
	);

	// add trailing space
	echo ' ';

	if (('open' == $post->comment_status) AND ('open' == $post->ping_status)) {

		// both comments and pings are open

		// define trackback text
		$trackback_text = __( 'trackback', 'commentpress-core' );

		// construct RSS link
		$trackback_link = '<a href="' . esc_url( get_trackback_url() ) . '"rel="trackback">' . $trackback_text . '</a>';

		// write out
		echo sprintf(
			__( 'You can leave a comment, or %s from your own site.' ),
			$trackback_link
		);

		// add trailing space
		echo ' ';

	} elseif (!('open' == $post->comment_status) AND ('open' == $post->ping_status)) {

		// only pings are open

		// define trackback text
		$trackback_text = __( 'trackback', 'commentpress-core' );

		// construct RSS link
		$trackback_link = '<a href="' . esc_url( get_trackback_url() ) . '"rel="trackback">' . $trackback_text . '</a>';

		// write out
		echo sprintf(
			__( 'Comments are currently closed, but you can %s from your own site.', 'commentpress-core' ),
			$trackback_link
		);

		// add trailing space
		echo ' ';

	} elseif (('open' == $post->comment_status) AND !('open' == $post->ping_status)) {

		// comments are open, pings are not
		_e( 'You can leave a comment. Pinging is currently not allowed.', 'commentpress-core' );

		// add trailing space
		echo ' ';

	} elseif (!('open' == $post->comment_status) AND !('open' == $post->ping_status)) {

		// neither comments nor pings are open
		_e( 'Both comments and pings are currently closed.', 'commentpress-core' );

		// add trailing space
		echo ' ';

	}

	// show edit link
	edit_post_link( __( 'Edit this entry', 'commentpress-core' ), '', '.' );

?></p>



</div><!-- /post -->



</div><!-- /content -->



<?php

// did we get tabs?
if ( $tabs_class != '' ) {

	// did we get either type of workflow content?
	if ( $literal != '' OR $original != '' ) {

	// did we get literal?
	if ( $literal != '' ) {

	?>
	<div id="literal" class="workflow-wrapper">

	<div class="post">

	<h2 class="post_title"><?php
		echo apply_filters(
			'commentpress_literal_title',
			__( 'Literal Translation', 'commentpress-core' )
		);
	?></h2>

	<?php echo apply_filters( 'cp_workflow_richtext_content', $literal ); ?>

	</div><!-- /post -->

	</div><!-- /literal -->

	<?php } ?>


	<?php

	// did we get original?
	if ( $original != '' ) {

	?>

	<div id="original" class="workflow-wrapper">

	<div class="post">

	<h2 class="post_title"><?php
		echo apply_filters(
			'commentpress_original_title',
			__( 'Original Text', 'commentpress-core' )
		);
	?></h2>

	<?php echo apply_filters( 'cp_workflow_richtext_content', $original ); ?>

	</div><!-- /post -->

	</div><!-- /original -->

	<?php } ?>



	<?php

	}

}

?>



<div class="page_nav_lower">
<?php

// include page_navigation again
if ( $cp_page_navigation != '' ) load_template( $cp_page_navigation, false );

?>
</div><!-- /page_nav_lower -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



<?php endwhile; else: ?>



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content">



<div class="post">

<h2 class="post_title"><?php _e( 'Post Not Found', 'commentpress-core' ); ?></h2>

<p><?php _e( 'Sorry, no posts matched your criteria.', 'commentpress-core' ); ?></p>

<?php get_search_form(); ?>

</div><!-- /post -->



</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



<?php endif; ?>



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>
