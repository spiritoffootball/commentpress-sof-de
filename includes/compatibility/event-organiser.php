<?php /*
================================================================================
Event Organiser compatibility for CommentPress Child Theme.
================================================================================
AUTHOR: Christian Wach <needle@haystack.co.uk>
--------------------------------------------------------------------------------
NOTES
=====

--------------------------------------------------------------------------------
*/



/**
 * Amend query for upcoming events
 */
function commentpress_sof_de_upcoming_events_page( $query ) {

	// is this an EO query?
	if ( eventorganiser_is_event_query( $query, true ) ) {

		// target our query
		if ( $query->get( 'commentpress_sof_de' ) && 'upcoming-events' == $query->get( 'commentpress_sof_de' ) ) {

			// show only upcoming events
			$query->set( 'event_start_after', 'now' );

			// this is needed for now, but maybe redundant in the future...
			$query->set( 'showpastevents', true );

		}

	}

}

// add action for the above
add_action( 'pre_get_posts', 'commentpress_sof_de_upcoming_events_page', 5 );



/**
 * Amend query vars for upcoming events (see above)
 */
function commentpress_sof_de_register_query_vars( $qvars ){

	// add our query var
	$qvars[] = 'commentpress_sof_de';

	// --<
	return $qvars;

}

// add filter for the above
add_filter( 'query_vars', 'commentpress_sof_de_register_query_vars' );



/**
 * Amend rewrite rules for upcoming events (see above)
 */
function commentpress_sof_de_add_rewrite_rule() {

	global $wp_rewrite;

	// get base regex
	$regex = str_replace( '%event%', 'upcoming-events', $wp_rewrite->get_extra_permastruct( 'event' ) );

	// get pagination base regex
	$pageregex = $wp_rewrite->pagination_base . '/?([0-9]{1,})/?$';

	 // add paged rewrite rule
	add_rewrite_rule(
		$regex . '/' . $pageregex,
		'index.php?post_type=event&paged=$matches[1]&event_start_after=now&commentpress_sof_de=upcoming-events',
		'top'
	);

	 // add standard rewrite url
	add_rewrite_rule(
		$regex,
		'index.php?post_type=event&event_start_after=now&commentpress_sof_de=upcoming-events',
		'top'
	);

}

// add action for the above
add_action( 'init', 'commentpress_sof_de_add_rewrite_rule', 11 );



