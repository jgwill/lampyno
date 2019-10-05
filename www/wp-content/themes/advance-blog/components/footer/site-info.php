<div class="site-info">
	<div class="wrapper">
        <?php
        $bm_footer_text = advance_blog_get_option('footer_credit_text');
        if (!empty($bm_footer_text)){ ?>
            <?php echo esc_html(advance_blog_get_option('footer_credit_text')); ?>
            <span class="sep"> | </span>
        <?php } ?>
		<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'advance-blog' ), 'Advance Blog', '<a href="http://wpinterface.com/" rel="designer">WPinterface</a>' ); ?>
	</div>
</div><!-- .site-info -->


<a id="scroll-top">
    <i class="ion-ios-arrow-up"></i>
</a>