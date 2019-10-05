<?php
/**
 * The template used for displaying page breadcrumb
 *
 * @package modulus
 */
 $breadcrumb = get_theme_mod( 'breadcrumb',true ); ?>       
    <div class="breadcrumb">
		<div class="container">
			<div class="breadcrumb-left eight columns">
				<?php the_title('<h4>','</h4>');?>			
			</div>
			<?php if( $breadcrumb ) : ?>
				<div class="breadcrumb-right eight columns">
					<?php modulus_breadcrumbs(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>