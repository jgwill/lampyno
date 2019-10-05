<?php
//nothing to do if post_password_required
if( post_password_required() ) {
	return;
}

// If comments are not open or we have not any comment, do not load up the comment template.
if( ! have_comments() && ! comments_open() ) {
	return;
}
?>

<div class="content-first single-posst" id="commentcount">
	
	<div class="content-second">
		<h3 class="the-title cmnthdlne_ctmzr"><?php echo di_business_comment_panel_headline(); ?></h3>
	</div>
	
	<div class="content-third">
		<div id="comments" class="comments-area">

			<?php
			if ( have_comments() ) {
			?>
			
				<h4 class="comments-title">
					<?php
					printf( _nx( '%3$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'di-business' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>', __( 'One', 'di-business' ) );
					?>
				</h4>

				<?php
				wp_list_comments( array(
				'style'		=> 'div',
				'type'		=> 'comment',
				'callback'	=> 'di_business_comments',
				) );
				?>

				<?php
				wp_list_comments( array(
				'style'		=> 'div',
				'type'		=> 'pings',
				) );
				?>


				<?php
				// Are there comments to navigate through?
				if( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
				?>
					<div class="clearfix"></div>
					<nav class="navigation post-navigation dicomntnav" role="navigation">
						<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'di-business' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'di-business' ) ); ?></div>
					</nav>
					<div class="clearfix"></div>
				<?php
				}
				?>

			<?php
			}
			?>

			<?php
			if( comments_open() ) {
				comment_form();
			} else {
			?>
				<div class="alert alert-info mrt20">
				<?php esc_attr_e( 'Comments are closed for this post !!', 'di-business' ); ?>
				</div>
			<?php
			}
			?>

		</div>
	</div>
</div>
