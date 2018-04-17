/*
================================================================================
CommentPress Spirit of Football Germany Javascript
================================================================================
AUTHOR: Christian Wach <needle@haystack.co.uk>
--------------------------------------------------------------------------------
NOTES

Theme-specific scripts.

--------------------------------------------------------------------------------
*/



/**
 * Document loaded and ready to go.
 *
 * @since 1.0
 */
jQuery(document).ready( function($) {

	// first pass
	$('.post, .comments_container, .activity-inner').fitVids();

	// refresh after any AJAX event completes
	$(document).ajaxComplete(function() {
		setTimeout( function() {
			$('.post, .comments_container, .activity-inner').fitVids();
		}, 200 );
	});

});



