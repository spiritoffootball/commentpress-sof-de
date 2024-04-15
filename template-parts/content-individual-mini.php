<?php
/**
 * Template part for displaying an Individual in archives.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package The_Ball_v2
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<!-- content-individual-mini.php -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php $image = get_field( 'picture' ); ?>
		<?php if ( ! empty( $image ) ) : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><img class="avatar" src="<?php echo esc_url( $image['sizes']['large'] ); ?>" width="<?php echo esc_attr( $image['sizes']['large-width'] / 2 ); ?>" height="<?php echo esc_attr( $image['sizes']['large-height'] / 2 ); ?>"></a>
		<?php else : ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><img class="avatar" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/images/misc/default-avatar.png" width="320" height="320" /></a>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

	<?php $job_title = get_field( 'job_title_de' ); ?>
	<?php if ( ! empty( $job_title ) ) : ?>
		<div class="individual-job-title">
			<?php echo esc_html( $job_title ); ?>
		</div>
	<?php endif; ?>

	<?php $about = get_field( 'summary_de' ); ?>
	<?php if ( ! empty( $about ) ) : ?>
		<div class="individual-about">
			<?php echo $about; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		</div>
	<?php endif; ?>

	<?php $email = get_field( 'email' ); ?>
	<?php if ( ! empty( $email ) ) : ?>
		<div class="individual-email">
			<?php echo esc_html( str_replace( '@', '[at]', $email ) ); ?>
		</div>
	<?php endif; ?>

	<footer class="entry-footer">
		<?php $cat_list = get_the_term_list( get_the_ID(), 'individual-type', '<p class="individual-tags"><span>', '</span><span>', '</span></p>' ); ?>
		<?php if ( ! empty( $cat_list ) && ! is_wp_error( $cat_list ) ) : ?>
			<div class="individual-type-terms">
				<?php echo $cat_list; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
			</div>
		<?php endif; ?>
		<?php $tag_list = get_the_term_list( get_the_ID(), 'individual-tag', '<p class="individual-tags"><span>', '</span><span>', '</span></p>' ); ?>
		<?php if ( ! empty( $tag_list ) && ! is_wp_error( $tag_list ) ) : ?>
			<div class="individual-tag-terms">
				<?php echo $tag_list; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
			</div>
		<?php endif; ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-->
