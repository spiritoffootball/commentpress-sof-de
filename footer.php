<?php
/**
 * Footer Template.
 *
 * Elements were opened in "assets/templates/header_body.php".
 *
 * @since 1.0.0
 * @package CommentPress_SOF
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<!-- footer.php -->

</div><!-- /content_container -->

<div id="footer">

	<div id="footer_inner">

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<?php

			// Show footer menu if assigned.
			$menu_args = [
				'theme_location'  => 'footer',
				'container_class' => 'commentpress-footer-nav-menu',
			];
			wp_nav_menu( $menu_args );

			?>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'cp-license-8' ) ) : ?>
			<div class="footer_widgets">
				<?php dynamic_sidebar( 'cp-license-8' ); ?>
			</div>
		<?php endif; ?>

		<?php /* translators: 1: The site title, 2: The current year. */ ?>
		<p><?php echo sprintf( esc_html__( 'Website content &copy; %1$s %2$s. All rights reserved.', 'commentpress-sof-de' ), '<a href="' . esc_url( home_url() ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>', esc_html( gmdate( 'Y' ) ) ); ?></p>

	</div><!-- /footer_inner -->

</div><!-- /footer -->

</div><!-- /container -->

<?php wp_footer(); ?>
</body>

</html>
