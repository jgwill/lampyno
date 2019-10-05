<?php
if( get_theme_mod( 'sb_menu_onoff', '1' ) == 1 ) {
	?>
	<div class="side-menu-menu-wrap">
		<?php
		wp_nav_menu( array(
			'theme_location'    => 'sidebar',
			'depth'             => 1,
			'container'         => 'nav',
			'container_id'      => 'side-menu-menu',
			'container_class'   => 'side-menu-menu',
			'menu_id' 			=> 'side-menu',
			'menu_class'        => 'side-menu-icon-list',
			) );
		?>
		<button class="side-menu-close-button" id="side-menu-close-button"></button>
	</div>
	<a id="side-menu-open-button" href="#" class="side-menu-menu-button">
		<span class="fa fa-bars"></span>
	</a>
	<?php
}
