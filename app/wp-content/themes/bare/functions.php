<?php

if ( ! isset( $content_width ) )
	$content_width = 640;

add_editor_style();

add_theme_support( 'post-thumbnails' );

add_theme_support( 'automatic-feed-links' );

add_custom_background();

add_custom_image_header( '', 'bare_admin_header_style' );


if ( ! function_exists( 'bare_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 */
function bare_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

function register_bare_menus(){

register_nav_menus(
array(
'header-menu' => __( 'Header Menu' )
)
);
}
add_action( 'init', 'register_bare_menus' );

if ( function_exists('register_sidebar') ){
    	register_sidebar();
}

if ( ! function_exists( 'bare_comment' ) ) :

function bare_comment( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

	echo '<li ';
		comment_class();
	echo join(array(
		' id="li-comment-',
		$comment->comment_ID,
		'">',
		'<span>',
		$comment->comment_author,
		' said: </span>',
		$comment->comment_content,
		'</li>'
	));

}
endif;

if ( ! function_exists( 'bare_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 */
function bare_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'bare' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'bare' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'bare' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

if ( ! function_exists( 'bare_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 */
function bare_posted_on() {
	printf( __( '<span class="meta-prep meta-prep-author">Posted on</span> %1$s', 'bare' ),
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		)
	);
}
endif;


/**
 * wpi_stylesheet_dir_uri
 * overwrite theme stylesheet directory uri
 * filter stylesheet_directory_uri
 * @see get_stylesheet_directory_uri()
 */
function wpi_stylesheet_dir_uri($stylesheet_dir_uri, $theme_name){
	$subdir = '/css';
	return $stylesheet_dir_uri.$subdir;
}
add_filter('stylesheet_directory_uri','wpi_stylesheet_dir_uri',10,2);


/*
 * Hide front-end toolbar
 */
add_filter( 'show_admin_bar', '__return_false' );


function yourprefix_tiny_mce_before_init( $init_array ) {
	$init_array['theme_advanced_buttons2_add_before'] = 'styleselect';
	$init_array['theme_advanced_styles'] = "Comment=comment;Continue=continue"
		.";Pretty Print=prettyprint;Pretty Print Numbered=prettyprint linenums"
		.";Pretty Print CSS=prettyprint linenums lang-css"
		.";Pretty Print HTML=prettyprint linenums lang-html"
		.";Pretty Print SQL=prettyprint linenums lang-sql";
	$init_array['theme_advanced_blockformats'] = "p,h1,h2,h3,pre"; // filter formats
	// $init_array['entities'] = '160,nbsp,38,amp,60,lt,62,gt';	
	// $init_array['entities'] = '38,amp,60,lt,62,gt';	
	return $init_array;
}
add_filter( 'tiny_mce_before_init', 'yourprefix_tiny_mce_before_init' );

?>
