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
				<!-- Hey, sidebar is not defined -->
			<?php endif; // end sidebar widget area ?>
			<div class="item searchbar"></div>
			<div class="item active">
				<div class="title">Awesome post title</div>
				<div class="content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</div>
			</div>
			<div class="item">
				<div class="title">Awesome post title</div>
				<div class="content">Lorem dolor sit amet, conuer adipiscing elit. Aenean commodo dolor. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </div>
			</div>
			<div class="item">
				<div class="title">Awesome post title</div>
				<div class="content">Lorem dolor sit amet, conuer adipiscing elit. Aenean commodo dolor. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </div>
			</div>
			<div class="item">
				<div class="title">Awesome post title</div>
				<div class="content">Lorem dolor sit amet, conuer adipiscing elit. Aenean commodo dolor. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </div>
			</div>
			<div class="item">
				<div class="title">Awesome post title</div>
				<div class="content">Lorem dolor sit amet, conuer adipiscing elit. Aenean commodo dolor. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </div>
			</div>
			<div class="item">
				<div class="title">Awesome post title</div>
				<div class="content">Lorem dolor sit amet, conuer adipiscing elit. Aenean commodo dolor. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. </div>
			</div>
		</div>
	</div>