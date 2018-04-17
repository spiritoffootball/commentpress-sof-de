<?php

/**
 * BuddyPress - Users Profile
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<?php

// display activity stream for anyone other than me
if ( bp_loggedin_user_id() != bp_displayed_user_id() ) {

	bp_get_template_part( 'members/single/activity' );

} else { ?>

	<div class="sof-member-front">

		<div class="sof-member-widgets clearfix">
			<div class="sof-member-front-left">
				<?php if ( ! dynamic_sidebar( 'sof-member-front-left' ) ) {} ?>
			</div>

			<div class="sof-member-front-right">
				<?php if ( ! dynamic_sidebar( 'sof-member-front-right' ) ) {} ?>
			</div>
		</div>

	</div><!-- .sof-member-front -->

<?php } ?>

