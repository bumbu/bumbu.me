<?php
/**
 * The Template for displaying all single posts.
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
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<div class="entry-meta">
					<?php bare_posted_on(); ?>
				</div><!-- .entry-meta -->
			</div>
<?php endwhile; // end of the loop. ?>
			<div class="row-fluid navigation">
				<div class="span5">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'bare' ) . '</span> %title' ); ?></div>
				</div>
				<div class="span5">
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'bare' ) . '</span>' ); ?></div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>