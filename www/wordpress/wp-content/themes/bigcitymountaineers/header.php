<?php
/**
 * Header for BigCityMountaineers theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header id="site-header" class="site-header">
		<?php 
			// get logo
			$logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' );

			// get navigation
			$theme_locations = get_nav_menu_locations();
			$header_menu = get_term( $theme_locations['main-menu'], 'nav_menu' );
		?>
		<div class="site-header__primary">
			<div class="site-header__logo">
				<a href="/" class="site-header__logo-link" tabindex="0"><img src="<?php echo $logo[0]; ?>" alt="<?php bloginfo('name');?>" class="img-responsive" /></a>
			</div>
			<nav class="site-header__nav" aria-label="Main menu">
				<button class="site-header__mobile-nav-button" id="mobile-nav-button" aria-controls="site-navigation" aria-expanded="false" tabindex="0">
					<span><i></i><i></i><i></i></span>
					<span>Menu</span>
				</button>
				<div class="site-header__nav-collapse" id="site-header-nav-collapse">
					<ul class="site-header__nav-list" role="menubar">
					<?php if ( has_nav_menu( 'main-menu' ) ): ?>
						<?php $menu = wp_get_nav_menu_items($header_menu->name); ?>
						<?php 
							$count = 0;
							$submenu = false;
							foreach( $menu as $menu_item) {
								$link = $menu_item->url;
								$title = $menu_item->title;
								if ( !$menu_item->menu_item_parent ) {
									$parent_id = $menu_item->ID;
									$menu_list .= '<li class="site-header__nav-list-item">' ."\n";
									$menu_list .= '<a href="'.$link.'" class="site-header__nav-link" tabindex="0"><span>'.$title.'</span></a>' ."\n";
								}
								if ( $parent_id == $menu_item->menu_item_parent ) {
									if ( !$submenu ) {
										$submenu = true;
										$menu_list .= '<ul class="site-header__sub-nav-list">' ."\n";
									}
									$menu_list .= '<li class="site-header__sub-nav-list-item">' ."\n";
									$menu_list .= '<a href="'.$link.'" class="site-header__sub-nav-link" tabindex="0"><span>'.$title.'</span></a>' ."\n";
									$menu_list .= '</li>' ."\n";
									if ( $menu[ $count + 1 ]->menu_item_parent != $parent_id && $submenu ){
										$menu_list .= '</ul>' ."\n";
										$submenu = false;
									}
								}
								if ( $menu[ $count + 1 ]->menu_item_parent != $parent_id ) { 
									$menu_list .= '</li>' ."\n";      
									$submenu = false;
								}
						
								$count++;
							}
							echo $menu_list;
							?>		
					<?php endif; ?>
						<li class="site-header__nav-list-item site-header__nav-list-item--donate">
							<a href="/donate" class="site-header__nav-link site-header__nav-link--donate" tabindex="0"><span>Donate</span></a>
						</li>
					</ul>
				</div>
			</nav>
		</div>
	</header>
	<main id="main" class="main">