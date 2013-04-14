<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Bare 
 * @since Bare 1.0
 */

get_header(); ?>
	<div class="row">
		<div class="span10">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<div class="box">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
<?php endwhile; ?>			
		</div>
	</div>
<?php get_footer(); ?>
