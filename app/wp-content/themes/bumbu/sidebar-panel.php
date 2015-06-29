<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package bumbu
 */
?>
	<div class="sidebar">
		<a href="#" class="sidebar-trigger" id="sidebar-trigger"><span class="lines"></span></a>
		<div class="sidebar-primary" id="sidebar-main">
			<a href="<?php echo site_url(); ?>" class="logo"><i class="icon icon-bumbu" id="icon-logo"></i></a>
			<?php if ( ! dynamic_sidebar( 'sidebar-panel-main' ) ) : ?>
			<?php endif; // end sidebar widget area ?>

			<?php
				$menu_name = 'primary';
				$category_active = 0;
				$category_active_title = 'bumbu';
				$category_first = 0;
				$category_post = 0;
				$visible_categories = array();

				if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
					$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

					$menu_items = wp_get_nav_menu_items($menu->term_id);
					_wp_menu_item_classes_by_context($menu_items);

					$menu_list = '<ul id="menu-' . $menu_name . '" class="menu">';

					// Search for active category
					foreach ( $menu_items as $key => $menu_item ) {
						if ($menu_item->object == 'category') {
							if($category_active === 0 && in_array('current-menu-item', $menu_item->classes)){
								$category_active = $menu_item->object_id;
							}

							if($category_post === 0 && in_array('current-post-parent', $menu_item->classes)){
								$category_post = $menu_item->object_id;
							}

							$visible_categories[] = $menu_item->object_id;
						}
					}

					// Default category is
					if($category_active === 0){
						$category_active = $category_post > 0 ? $category_post : 0;
					}

					if($category_active === 0){
						$categories = get_the_category(get_the_ID());
						foreach ($categories as $category) {
							if(in_array($category->term_id, $visible_categories)){
								$category_active = $category->term_id;
								break;
							}
						}
					}

					foreach ( $menu_items as $key => $menu_item ) {
						// Check for category
						if($menu_item->object == 'category' && $menu_item->object_id == $category_active){
							$menu_item->classes[] = 'active';
							$category_active_title = $menu_item->title;
						}

						// Build like
						$title = $menu_item->title;
						$url = $menu_item->url;
						$li_class = join(' ', $menu_item->classes);
						$a_class = 'icon icon-'.strtolower($menu_item->title);
						$id = $menu_item->object_id;

						$menu_list .= '<li class="' . $li_class . '"><a class="' . $a_class . '" data-id="'. $id .'" href="' . $url . '"></a></li>';
					}
					$menu_list .= '</ul>';
				}
				echo $menu_list;
			?>
		</div>
		<div class="sidebar-secondary" id="sidebar-secondary">
			<?php if ( ! dynamic_sidebar( 'sidebar-panel-first' ) ) : ?>
				<div class="item header">
					<h4><?php echo $category_active_title; ?></h4>
				</div>
				<div class="items">
				<?php
				$_posts = wp_get_recent_posts(array(
					'numberposts' => 50
				,	'category' => $category_active
				,	'post_status' => 'publish'
				));
				$active_id = get_the_ID();

				foreach ($_posts as $key => $_post) {

					if ($active_id == $_post['ID']) {
					?>
						<a class="item active" href="<?php echo get_permalink($_post['ID'])?>"><span class="title"><?php echo $_post['post_title']; ?></span></a>
					<?php
					} else {
					?>
						<a class="item" href="<?php echo get_permalink($_post['ID'])?>"><span class="title"><?php echo $_post['post_title']; ?></span></a>
					<?php
					}

				}
				?>
				</div><!-- .items -->
			<?php endif; // end sidebar widget area ?>
		</div>
	</div>
<?php

// Get categories
$categories = array();
foreach ($menu_items as $key => $menu_item) {
	if ($menu_item->object == 'category') {
		$categories[] = array(
			'id' => $menu_item->object_id
		, 'title' => $menu_item->title
		, 'posts' => array()
		, 'is_active' => $menu_item->object_id == $category_active
		);
	}
}

// Mapper function
function postData($post) {
	return array(
		'ID' => $post['ID']
	, 'title' => $post['post_title']
	, 'url' => get_permalink($post['ID'])
	, 'is_active' => $post['ID'] == get_the_ID()
	);
}

// For each category get articles
foreach ($categories as $category_id => &$category) {
	$category['posts'] = array_map(postData, wp_get_recent_posts(array(
		'numberposts' => 50
	,	'category' => $category['id']
	,	'post_status' => 'publish'
	)));
}

?>
<script>
	var CATEGORIES = '<?php echo str_replace("'", "\'", json_encode($categories)); ?>';
</script>
