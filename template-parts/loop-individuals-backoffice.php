<?php
/**
 * Template part for embedding a display of Individuals in The Squad.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package The_Ball_v2
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Define query args.
$board_args = [
	'post_type' => 'individual',
	'post_status' => 'publish',
	'order' => 'ASC',
	'orderby' => 'title',
	'posts_per_page' => -1,
	'tax_query' => [
		[
			'taxonomy' => 'individual-type',
			'field' => 'slug',
			'terms' => 'backoffice',
		],
	],
];

// Do the query.
$board = new WP_Query( $board_args );

if ( $board->have_posts() ) : ?>

	<!-- loop-individuals-board.php -->
	<section id="individuals-board" class="content-area clear">
		<div class="individuals-inner">

			<header class="individuals-header">
				<h2 class="individuals-title"><?php esc_html_e( 'Das Backoffice', 'commentpress-sof-de' ); ?></h2>
			</header><!-- .individuals-header -->

			<div class="individuals-posts clear">
				<?php

				// Start the loop.
				while ( $board->have_posts() ) :

					$board->the_post();

					// Get mini template.
					get_template_part( 'template-parts/content-individual-mini' );

				endwhile;

				?>
			</div><!-- .individuals-posts -->

		</div><!-- .individuals-inner -->
	</section><!-- #individuals -->

	<?php

	// Prevent weirdness.
	wp_reset_postdata();

endif;

