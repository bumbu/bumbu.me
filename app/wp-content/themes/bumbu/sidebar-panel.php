<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package bumbu
 */
?>
	<div class="panels">
		<div class="panel-main open_">
			<a href="#" class="logo"><i class="icon icon-bumbu-logo"></i><div class="logo-image"><img src="<?php bloginfo( 'template_url' ); ?>/img/logo-bumbu-text.png" alt="bumbu logo" width="116" height="24"></div></a>
			<?php if ( ! dynamic_sidebar( 'sidebar-panel-main' ) ) : ?>
				<!-- Hey, sidebar is not defined -->
			<?php endif; // end sidebar widget area ?>
			<ul class="menu">
				<li class="active"><a class="icon icon-blog" href="#">Blog</a></li>
				<li><a class="icon icon-about" href="#">About</a></li>
				<li><a class="icon icon-catalog" href="#">Catalog</a></li>
				<li><a class="icon icon-experiments" href="#">Experiments</a></li>
			</ul>
		</div>
		<div class="panel-first">
			<?php if ( ! dynamic_sidebar( 'sidebar-panel-first' ) ) : ?>
				<div class="item searchbar"></div>
				<?php 
				$_posts = wp_get_recent_posts(array(
					'numberposts' => 50
				,	'category' => 4 // Blog category
				,	'post_status' => 'publish'
				));
				foreach ($_posts as $key => $_post) {
					?>
					<div class="item <?php echo $_post['ID'] == get_the_ID() ? 'active' : '';?>">
						<div class="title"><?php echo $_post['post_title']; ?></div>
						<div class="content"><?php echo $_post['post_excerpt']; ?></div>
					</div>
					<?php
				}
				?>
			<?php endif; // end sidebar widget area ?>
		</div>
	</div>