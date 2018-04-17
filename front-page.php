<?php get_header(); ?>



<!-- front-page.php -->

<div id="wrapper">



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



	<div id="main_wrapper" class="clearfix">

	<div id="page_wrapper" class="page_wrapper front_page">

	<?php commentpress_get_feature_image(); ?>

	<div id="content" class="content workflow-wrapper">

	<div class="post<?php echo commentpress_get_post_css_override( get_the_ID() ); ?>" id="post-<?php the_ID(); ?>">



		<?php // do we have a featured image?
		if ( ! commentpress_has_feature_image() ) { ?>
			<h2 class="post_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<?php
		} ?>



		<?php the_content(); ?>



	</div><!-- /post -->

	</div><!-- /content -->

	</div><!-- /page_wrapper -->



	<div class="cp-homepage-widgets clear">

		<div class="cp-homepage-left">
			<?php if ( ! dynamic_sidebar( 'cp-homepage-left' ) ) {} ?>
		</div>

		<div class="cp-homepage-right">
			<?php if ( ! dynamic_sidebar( 'cp-homepage-right' ) ) {} ?>
		</div>

		<div class="cp-homepage-below">
			<?php if ( ! dynamic_sidebar( 'cp-homepage-below' ) ) {} ?>
		</div>

	</div>



	</div><!-- /main_wrapper -->



<?php endwhile; else: ?>



	<div id="main_wrapper" class="clearfix">

	<div id="page_wrapper" class="page_wrapper">

	<div id="content" class="content">

	<div class="post">

		<h2 class="post_title"><?php _e( 'Page Not Found', 'commentpress-core' ); ?></h2>

		<p><?php _e( "Sorry, but you are looking for something that isn't here.", 'commentpress-core' ); ?></p>

		<?php get_search_form(); ?>

	</div><!-- /post -->

	</div><!-- /content -->

	</div><!-- /page_wrapper -->

	</div><!-- /main_wrapper -->



<?php endif; ?>



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>
