<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Bare 
 * @since Bare 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) : ?>
				<div class="box box_head">
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'bare' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</div>
				<?php
				/* Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called loop-search.php and that will be used instead.
				 */
				 get_template_part( 'loop', 'search' );
				?>
<?php else : ?>
				<div id="post-0" class="box">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'bare' ); ?></h1>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'bare' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
<?php endif; ?>
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
