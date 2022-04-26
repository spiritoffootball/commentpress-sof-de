/*
================================================================================
CommentPress Spirit of Football Javascript
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

	// First pass.
	$('.post, .comments_container, .activity-inner, .widget_media_video').fitVids({
		customSelector: "iframe.dfb-video"
	});

	// Refresh after any AJAX event completes.
	$(document).ajaxComplete(function() {
		setTimeout( function() {
			$('.post, .comments_container, .activity-inner').fitVids();
		}, 200 );
	});

});
