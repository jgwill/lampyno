<?php
// Add adjustment class if longer title
$title_class = null;
if ( strlen( $args['creation']['title'] ) > 50 ) {
	$title_class = ' mv-create-title-long';
}
?>

<div class="mv-create-title-container<?php echo esc_attr( $title_class ); ?>">

	<?php if ( ! empty( $args['creation']['yield'] ) ) { ?>
		<span class="mv-create-yield mv-create-uppercase"><span class="screen-reader-text"><?php esc_html_e( 'Yield', 'mediavine' ); ?>:</span> <?php echo esc_html( $args['creation']['yield'] ); ?></span>
	<?php } ?>

	<?php
	// Add adjustment class if longer title
	$title_class = null;
	if ( strlen( $args['creation']['title'] ) > 50 ) {
		$title_class = ' mv-create-title-long';
	}
	?>

	<h1 class="mv-create-title mv-create-title-primary"><span><?php echo esc_html( $args['creation']['title'] ); ?></span></h1>

</div>
