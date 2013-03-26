<?php
/**
 * @package bumbu
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'bumbu' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

	<div class="post-content">
		<?php the_content(); ?>
	</div>
</div>
