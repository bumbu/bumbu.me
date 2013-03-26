<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package bumbu
 */
get_header(); ?>
	<div id="content" class="site-content" role="main">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content' ); ?>
		<?php endwhile; ?>
	<?php else : ?>
		<?php get_template_part( 'no-results', 'index' ); ?>
	<?php endif; ?>
	</div><!-- #content -->
<?php get_footer(); ?>
