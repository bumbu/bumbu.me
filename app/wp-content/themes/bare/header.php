<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Bare 
 * @since Bare 1.0 
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'bare' ), max( $paged, $page ) );

	?></title>
<!--
<link rel="profile" href="uri for xhtml profile" />
-->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<!-- <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/prettify.css" /> -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
	<script type="text/javascript" src="<?php echo bloginfo('template_url');?>/js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="<?php echo bloginfo('template_url');?>/js/script.js"></script>
	<!--<script type="text/javascript" src="<?php echo bloginfo('template_url');?>/js/prettify.js"></script>-->

	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-34516109-2']);
	  _gaq.push(['_setDomainName', 'bumbu.ru']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</head>

<body <?php body_class(); ?>><!-- onload="prettyPrint()"-->
<div id="main">
<div id="container" class="container">
	<header class="row">
		<div class="span7">
			<nav role="navigation"><?php
				$cat_id = (int)get_query_var('cat');
				if($cat_id == 0 && is_single()){
					$the_category = get_the_category();
					$cat_id = count($the_category) ? $the_category[0]->cat_ID : 0;
				}
				$page_id = (isset($post) && isset($post->ID)) ? $post->ID : 0;
			?>	<a href="<?php echo get_category_link(4);?>" class="first<?php echo ($cat_id == 4 ? ' active' : '');?>">Blog</a>
				<span class="divider">/</span>
				<a href="<?php echo get_category_link(5);?>" class="second<?php echo ($cat_id == 5 ? ' active' : '');?>">DIY</a>
				<a href="<?php echo get_category_link(6);?>" class="first<?php echo ($cat_id == 6 ? ' active' : '');?>">Dev</a>
				<span class="divider">/</span>
				<a href="<?php echo get_category_link(7);?>" class="second<?php echo ($cat_id == 7 ? ' active' : '');?>">Experiments</a>
				<a href="<?php echo get_permalink(13);?>" class="first<?php echo ($page_id == 13 ? ' active' : '');?>">About</a>
				<span class="divider">/</span>
				<a href="<?php echo get_permalink(15);?>" class="second<?php echo ($page_id == 15 ? ' active' : '');?>">Quotes I like</a>
			</nav>
			
		</div>
		<div class="span3">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo"></a>
			<!-- <a href="#" class="avatar pull-right"></a> -->
		</div>
		<div class="clear"></div>
	</header>