<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Bare 
 * @since Bare 1.0
 */

get_header(); ?>
	<div class="row">
		<div class="span7">
			<?php
			/* Run the loop for the category page to output the posts.
			 * If you want to overload this in a child theme then include a file
			 * called loop-category.php and that will be used instead.
			 */
			get_template_part( 'loop', 'category' );
			?>
		</div>
		<div class="span3">
			<div class="box">
				reserved
			</div>
		</div>
	</div>
<?php get_footer(); ?>
