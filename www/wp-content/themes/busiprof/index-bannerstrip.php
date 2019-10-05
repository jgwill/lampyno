<?php
$current_options = wp_parse_args(  get_option( 'busiprof_theme_options', array() ), theme_setup_data() );
 ?>
<!-- Page Title -->
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="page-title">
					<h2><?php 
						if( is_archive() ){ 
						
						if( is_shop() ){
			
						printf( __( '%1$s %2$s', 'busiprof' ), $current_options['shop_prefix'], single_tag_title( '', false ));
						} elseif(is_archive()){
						
							the_archive_title(); 
						}
							
						}
						else if( is_home() ){
							
							wp_title(' ');
							
						}
						elseif( is_search() ){
							printf( __( '%1$s %2$s', 'busiprof' ), $current_options['search_prefix'], get_search_query() );
						}
						elseif( is_404() ){
							printf( __( '%1$s', 'busiprof' ), $current_options['404_prefix']);
						}
						
						else{ 
						
							the_title(); 
						}  
						?></h2>
					<p><?php bloginfo('description');?></p>
				</div>
			</div>
			<div class="col-md-6">
				<ul class="page-breadcrumb">
					<?php if (function_exists('busiprof_custom_breadcrumbs')) busiprof_custom_breadcrumbs();?>
				</ul>
			</div>
		</div>
	</div>	
</section>
<!-- End of Page Title -->
<div class="clearfix"></div>