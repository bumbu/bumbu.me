<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Bare 
 * @since Bare 1.0
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div class="box">
		<h1 class="entry-title"><?php _e( 'Not Found', 'bare' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'bare' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div>
<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * In Bare we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
<?php 
$article_counter = 0;
while ( have_posts() ) : the_post();
	if ( is_home() ){
		if($article_counter%2 == 0)
			echo '<div class="row-fluid"><div class="span5">';
		else
			echo '</div><div class="span5">';
	}
	?>

	<div class="box">
		<div class="date">
			<div class="day"><?php the_time('j'); ?></div>
			<div class="month"><?php strtoupper(the_time('M')); ?></div>
		</div>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'bare' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( is_search() || is_home() ) : // Only display excerpts for archives and search. ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bare' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'bare' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
		<?php endif; ?>
	</div><!-- #post-## -->

	<?php //comments_template( '', true ); ?>
	<?php
	if ( is_home() ){
		if($article_counter%2 == 0)
			echo '';
		else
			echo '</div></div>';

		$article_counter++;
	}
	?>
<?php endwhile; // End the loop. Whew.
if ( is_home() ){
	if($article_counter%2 == 1)
		echo '</div></div>';
}
?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div class="row-fluid navigation">
					<div class="span5">
						<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'bare' ) ); ?></div>
					</div>
					<div class="span5">
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'bare' ) ); ?></div>
					</div>
				</div>
<?php endif; ?>
