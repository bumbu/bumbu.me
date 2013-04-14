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
			<?php endif; // end sidebar widget area ?>

			<?php
				$menu_name = 'primary';
				$category_active = 0;
				$category_first = 0;
				$category_post = 0;
				$visible_categories = [];

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
						}

						// Build like
						$title = $menu_item->title;
						$url = $menu_item->url;
						$li_class = join(' ', $menu_item->classes);
						$a_class = 'icon icon-'.strtolower($menu_item->title);

						$menu_list .= '<li class="' . $li_class . '"><a class="' . $a_class . '" href="' . $url . '">' . $title . '</a></li>';
					}
					$menu_list .= '</ul>';
				}
				echo $menu_list;
			?>
		</div>
		<div class="panel-first">
			<?php if ( ! dynamic_sidebar( 'sidebar-panel-first' ) ) : ?>
				<div class="item searchbar"></div>
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
						<div class="item active">
							<div class="title"><?php echo $_post['post_title']; ?></div>
							<div class="content"><?php echo $_post['post_excerpt']; ?></div>
						</div>
					<?php
					} else {
					?>
						<div class="item" onclick="location.href='<?php echo $_post['guid']?>'">
							<a class="title" href="<?php echo $_post['guid']?>"><?php echo $_post['post_title']; ?></a>
							<div class="content"><?php echo $_post['post_excerpt']; ?></div>
						</div>
					<?php
					}

				}
				?>
			<?php endif; // end sidebar widget area ?>
		</div>
	</div>