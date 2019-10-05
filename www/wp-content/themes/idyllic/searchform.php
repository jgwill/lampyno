<?php
/**
 * Displays the searchform
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
?>
<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<?php
		$idyllic_settings = idyllic_get_theme_options();
		$idyllic_search_form = $idyllic_settings['idyllic_search_text'];
		if($idyllic_search_form !='Search &hellip;'): ?>
	<label class="screen-reader-text"><?php echo esc_html ($idyllic_search_form); ?></label>
	<input type="search" name="s" class="search-field" placeholder="<?php echo esc_attr($idyllic_search_form); ?>" autocomplete="off" />
	<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
	<?php else: ?>
	<input type="search" name="s" class="search-field" placeholder="<?php esc_attr_e( 'Search &hellip;', 'idyllic' ); ?>" autocomplete="off">
	<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
	<?php endif; ?>
</form> <!-- end .search-form -->