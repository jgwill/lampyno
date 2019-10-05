<div id="navbarouter" class="navbarouter">
<?php
if( class_exists( 'Mega_Menu' ) && max_mega_menu_is_enabled( 'primary' ) ) {
	wp_nav_menu( array( 'theme_location' => 'primary' ) );
} else {
?>
	<nav id="navbarprimary" class="navbar navbar-expand-md navbarprimary">
		<div class="container">
			<div class="navbar-header">
				<span class="small-menu-label"><?php esc_attr_e( 'Menu', 'di-business' ); ?></span>
				<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#collapse-navbarprimary">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>
					
			<?php
			wp_nav_menu( array(
				'theme_location'    => 'primary',
				'depth'             =>  3,
				'container'         => 'div',
				'container_id'      => 'collapse-navbarprimary',
				'container_class'   => 'collapse navbar-collapse',
				'menu_id' 			=> 'primary-menu',
				'menu_class'        => 'nav navbar-nav primary-menu',
				'fallback_cb'       => 'di_business_nav_fallback',
				'walker'            => new Di_Business_Nav_Menu_Walker()
				));
			?>

		</div>
	</nav>
<?php
}
?>
</div>
