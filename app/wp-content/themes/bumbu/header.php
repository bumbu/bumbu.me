<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package bumbu
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/font.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/application.css" />
</head>

<body <?php body_class(); ?>>
	<div class="panels">
		<div class="panel-main open_">
			<a href="#" class="logo"><i class="icon icon-bumbu-logo"></i><div class="logo-image"><img src="<?php bloginfo( 'template_url' ); ?>/img/logo-bumbu-text.png" alt="bumbu logo" width="116" height="24"></div></a>
			<ul class="menu">
				<li class="active"><a class="icon icon-blog" href="#">Blog</a></li>
				<li><a class="icon icon-about" href="#">About</a></li>
				<li><a class="icon icon-catalog" href="#">Catalog</a></li>
				<li><a class="icon icon-experiments" href="#">Experiments</a></li>
			</ul>
		</div>
		<div class="panel-first">
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
<div id="page" class="body-container hfeed site">
	<?php do_action( 'before' ); ?>

	<div id="main" class="site-main">
