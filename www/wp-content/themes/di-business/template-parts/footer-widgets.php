<?php

// Get current post ID (if on blog, then checks current posts page for it's ID)
if ( is_home() ) {
	$di_post_id = get_option( 'page_for_posts' );
} else {
	$di_post_id = get_the_ID();
}

// Do not load if disabled footer widgets using meta box options + do not check on posts loop page.
if( $di_post_id ) {
	if( get_post_meta( $di_post_id, '_di_business_hide_footer_widgets', true ) == '1' ) {
		return;
	}
}

$enordis = absint( get_theme_mod( 'endis_ftr_wdgt', '0' ) );
$layout = absint( get_theme_mod( 'ftr_wdget_lyot', '3' ) );

if( $enordis == 0 ) {
	return;
}

?>

<?php
//if set 1 widgets in customize
if( $layout == 1 ) {
	if( is_active_sidebar( 'footer_1' ) ) {
		echo '<div class="container-fluid footer clearfix"> <div class="container"> <div class="row pdt10 pdb5">';
			echo '<div class="col-md-12">';
			if( is_active_sidebar( 'footer_1' ) ) {
				dynamic_sidebar( 'footer_1' );
			}
			echo '</div>';
		echo '</div></div></div>';
	}
}
?>


<?php
//if set 2 widgets in customize
if( $layout == 2 ) {
	if( is_active_sidebar( 'footer_1' ) || is_active_sidebar( 'footer_2' ) ) {
		echo '<div class="container-fluid footer clearfix"> <div class="container"> <div class="row pdt10 pdb5">';
			echo '<div class="col-md-6">';
			if( is_active_sidebar( 'footer_1' ) ) {
				dynamic_sidebar( 'footer_1' );
			}
			echo '</div>';

			echo '<div class="col-md-6">';
			if( is_active_sidebar( 'footer_2' ) ) {
				dynamic_sidebar( 'footer_2' );
			}
			echo '</div>';
		echo '</div></div></div>';
	}
}
?>


<?php
//if set 3 widgets in customize
if( $layout == 3 ) {
	if( is_active_sidebar( 'footer_1' ) || is_active_sidebar( 'footer_2' ) || is_active_sidebar( 'footer_3' ) ) {
		echo '<div class="container-fluid footer clearfix"> <div class="container"> <div class="row pdt10 pdb5">';
			echo '<div class="col-md-4">';
			if( is_active_sidebar( 'footer_1' ) ) {
				dynamic_sidebar( 'footer_1' );
			}
			echo '</div>';

			echo '<div class="col-md-4">';
			if( is_active_sidebar( 'footer_2' ) ) {
				dynamic_sidebar( 'footer_2' );
			}
			echo '</div>';
				
			echo '<div class="col-md-4">';
			if( is_active_sidebar( 'footer_3' ) ) {
				dynamic_sidebar( 'footer_3' );
			}
			echo '</div>';
		echo '</div></div></div>';
	}
}
?>


<?php
//if set 4 widgets in customize
if( $layout == 4 ) {
	if( is_active_sidebar( 'footer_1' ) || is_active_sidebar( 'footer_2' ) || is_active_sidebar( 'footer_3' ) || is_active_sidebar( 'footer_4' ) ) {
		echo '<div class="container-fluid footer clearfix"> <div class="container"> <div class="row pdt10 pdb5">';
			echo '<div class="col-md-3">';
			if( is_active_sidebar( 'footer_1' ) ) {
				dynamic_sidebar( 'footer_1' );
			}
			echo '</div>';
			
			echo '<div class="col-md-3">';
			if( is_active_sidebar( 'footer_2' ) ) {
				dynamic_sidebar( 'footer_2' );
			}
			echo '</div>';
				
			echo '<div class="col-md-3">';
			if( is_active_sidebar( 'footer_3' ) ) {
				dynamic_sidebar( 'footer_3' );
			}
			echo '</div>';
				
			echo '<div class="col-md-3">';
			if( is_active_sidebar( 'footer_4' ) ) {
				dynamic_sidebar( 'footer_4' );
			}
			echo '</div>';
		echo '</div></div></div>';
	}
}
?>


<?php
//if set 48 widgets in customize
if( $layout == 48 ) {
	if( is_active_sidebar( 'footer_1' ) || is_active_sidebar( 'footer_2' ) ) {
		echo '<div class="container-fluid footer clearfix"> <div class="container"> <div class="row pdt10 pdb5">';
			echo '<div class="col-md-4">';
			if( is_active_sidebar( 'footer_1' ) ) {
				dynamic_sidebar( 'footer_1' );
			}
			echo '</div>';

			echo '<div class="col-md-8">';
			if( is_active_sidebar( 'footer_2' ) ) {
				dynamic_sidebar( 'footer_2' );
			}
			echo '</div>';
		echo '</div></div></div>';
	}
}
?>

<?php
//if set 84 widgets in customize
if( $layout == 84 ) {
	if( is_active_sidebar( 'footer_1' ) || is_active_sidebar( 'footer_2' ) ) {
		echo '<div class="container-fluid footer clearfix"> <div class="container"> <div class="row pdt10 pdb5">';
			echo '<div class="col-md-8">';
			if( is_active_sidebar( 'footer_1' ) ) {
				dynamic_sidebar( 'footer_1' );
			}
			echo '</div>';

			echo '<div class="col-md-4">';
			if( is_active_sidebar( 'footer_2' ) ) {
				dynamic_sidebar( 'footer_2' );
			}
			echo '</div>';
		echo '</div></div></div>';
	}
}
?>

