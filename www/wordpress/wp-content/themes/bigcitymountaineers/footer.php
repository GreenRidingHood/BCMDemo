<?php
/**
 * Fooer for BigCityMountaineers theme
 */
?>
	</main>
	<footer id="site-footer" class="site-footer">
		<?php 
			$theme_locations = get_nav_menu_locations();
			$menu_obj = get_term( $theme_locations['footer-menu'], 'nav_menu' );
			$menu_name = $menu_obj->name;
			$menu = wp_get_nav_menu_items($menu_name);
		?>
		<nav class="site-footer__nav">
			<ul class="site-footer__nav-list">
			<?php foreach( $menu as $menu_item): ?>
				<li class="site-footer__nav-item"><a href="<?php echo $menu_item->url; ?>" class="site-footer__nav-link"><?php echo $menu_item->title; ?>
					<span class="site-footer__nav-description"><?php echo $menu_item->description; ?></span>
				</a></li>
			<?php endforeach; ?>
			</ul>
		</nav>
	</footer>
<?php wp_footer(); ?>
</body>
</html>