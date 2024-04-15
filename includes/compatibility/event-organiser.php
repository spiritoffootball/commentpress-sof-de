<?php
/**
 * Event Organiser compatibility.
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

/**
 * Amend query for upcoming events.
 *
 * @since 1.0.0
 *
 * @param WP_Query $query The query object.
 */
function commentpress_sof_de_upcoming_events_page( $query ) {

	// is this an EO query?
	if ( eventorganiser_is_event_query( $query, true ) ) {

		// Target our query.
		if ( $query->get( 'commentpress_sof_de' ) && 'upcoming-events' === $query->get( 'commentpress_sof_de' ) ) {

			// Show only upcoming events.
			$query->set( 'event_start_after', 'now' );

			// This is needed for now, but maybe redundant in the future.
			$query->set( 'showpastevents', true );

		}

	}

}

// Add action for the above.
add_action( 'pre_get_posts', 'commentpress_sof_de_upcoming_events_page', 5 );



/**
 * Amend query vars for upcoming events.
 *
 * @since 1.0.0
 *
 * @param array $qvars The existing query vars.
 * @return array $qvars The modified query vars.
 */
function commentpress_sof_de_register_query_vars( $qvars ) {

	// Add our query var.
	$qvars[] = 'commentpress_sof_de';

	// --<
	return $qvars;

}

// Add filter for the above.
add_filter( 'query_vars', 'commentpress_sof_de_register_query_vars' );



/**
 * Amend rewrite rules for upcoming events.
 *
 * @since 1.0.0
 */
function commentpress_sof_de_add_rewrite_rule() {

	global $wp_rewrite;

	// Get base regex.
	$regex = str_replace( '%event%', 'upcoming-events', $wp_rewrite->get_extra_permastruct( 'event' ) );

	// Get pagination base regex.
	$pageregex = $wp_rewrite->pagination_base . '/?([0-9]{1,})/?$';

	// Add paged rewrite rule.
	add_rewrite_rule(
		$regex . '/' . $pageregex,
		'index.php?post_type=event&paged=$matches[1]&event_start_after=now&commentpress_sof_de=upcoming-events',
		'top'
	);

	// Add standard rewrite URL.
	add_rewrite_rule(
		$regex,
		'index.php?post_type=event&event_start_after=now&commentpress_sof_de=upcoming-events',
		'top'
	);

}

// Add action for the above.
add_action( 'init', 'commentpress_sof_de_add_rewrite_rule', 11 );
