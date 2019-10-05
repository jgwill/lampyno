<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package SKT Consulting
 */
get_header(); 

$hideslide = get_theme_mod('hide_slides', 1);
$secwithcontent = get_theme_mod('hide_sectionone', 1);
$hide_sectiontwo = get_theme_mod('hide_sectiontwo', 1);
$hide_home_third_content = get_theme_mod('hide_home_third_content', 1);

if (!is_home() && is_front_page()) { 
if( $hideslide == '') { ?>
<!-- Slider Section -->
<?php 
$pages = array();
for($sld=7; $sld<10; $sld++) { 
	$mod = absint( get_theme_mod('page-setting'.$sld));
    if ( 'page-none-selected' != $mod ) {
      $pages[] = $mod;
    }	
} 
if( !empty($pages) ) :
$args = array(
      'posts_per_page' => 3,
      'post_type' => 'page',
      'post__in' => $pages,
      'orderby' => 'post__in'
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) :	
	$sld = 7;
?>
<section id="home_slider">
  <div class="slider-wrapper theme-default">
    <div id="slider" class="nivoSlider">
		<?php
        $i = 0;
        while ( $query->have_posts() ) : $query->the_post();
          $i++;
          $skt_consulting_slideno[] = $i;
          $skt_consulting_slidetitle[] = get_the_title();
		  $skt_consulting_slidedesc[] = get_the_excerpt();
          $skt_consulting_slidelink[] = esc_url(get_permalink());
          ?>
          <img src="<?php the_post_thumbnail_url('full'); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" />
          <?php
        $sld++;
        endwhile;
          ?>
    </div>
        <?php
        $k = 0;
        foreach( $skt_consulting_slideno as $skt_consulting_sln ){ ?>
    <div id="slidecaption<?php echo esc_attr( $skt_consulting_sln ); ?>" class="nivo-html-caption">
      <div class="container">	
      <div class="slide_info">
        <h2><?php echo esc_html($skt_consulting_slidetitle[$k] ); ?></h2>
        <p><?php echo esc_html($skt_consulting_slidedesc[$k] ); ?></p>
        <div class="clear"></div>
        <a class="slide_more" href="<?php echo esc_url($skt_consulting_slidelink[$k] ); ?>">
          <?php esc_html_e('Get Started', 'skt-consulting');?>
          </a>
      </div>
      </div>
    </div>
 	<?php $k++;
       wp_reset_postdata();
      } ?>
<?php endif; endif; ?>
  </div>
  <div class="clear"></div>
</section>
<?php } } 
?>
<?php
	if(!is_home() && is_front_page()){ 
	if( $secwithcontent == '') {
?>
 <section id="sectionone">
 <div class="white-wave-bg"></div>
 	<div class="container">
      <div class="home_section1_content">
         	 <?php 
	  		if( get_theme_mod('page-column1',false)) {
			$sectiononequery = new WP_query('page_id='.get_theme_mod('page-column1',true)); 
			while( $sectiononequery->have_posts() ) : $sectiononequery->the_post(); ?>
            <?php if( has_post_thumbnail() ) { ?><div class="hm-leftcols"><?php the_post_thumbnail('full'); ?></div><?php } ?>
            <div class="hm-rightcols">
            <h2>
				<?php
                $section1_title = get_theme_mod('section1_title');
                if(!empty($section1_title)){?>
                <small><?php echo esc_attr($section1_title); ?></small>
                <?php } ?>
                <?php the_title(); ?>
            </h2>
            <?php the_content(); ?>              
            </div>
          	<?php endwhile;
       		wp_reset_postdata(); 
	   		} ?>
            <div class="clear"></div>
      </div>
    </div>
 </section>
<?php }} ?>
<?php
if (!is_home() && is_front_page()) { 
if( $hide_sectiontwo == '') { ?>
<section class="hometwo_section_area">
<div class="gray-wave-bg"></div>
    	<div class="center">
            <div class="hometwo_section_content">
         	  <?php 
	  		if( get_theme_mod('page-column2',false)) {
			$sectiontwoquery = new WP_query('page_id='.get_theme_mod('page-column2',true)); 
			while( $sectiontwoquery->have_posts() ) : $sectiontwoquery->the_post(); ?>
            <div class="hm-leftcols">
              <h2>
                <?php
				$section1_title = get_theme_mod('section1_title');
				if(!empty($section1_title)){?>
                <small><?php echo esc_attr($section1_title); ?></small>
                <?php } ?>
                <?php the_title(); ?>
              </h2>
              <?php the_content(); ?>
            </div>
            <?php if( has_post_thumbnail() ) { ?>
            <div class="hm-rightcols">
              <?php the_post_thumbnail('full'); ?>
            </div>
            <?php } ?>
            <?php endwhile;
                  wp_reset_postdata(); 
            } ?>
            <div class="clear"></div>
            </div>
        </div>    
    </section>
<?php } } ?>
<?php if (!is_home() && is_front_page()) {
	  if( $hide_home_third_content == '' ){	
?>
<section class="home3_section_area">
 <div class="white-wave-bg"></div>
  <div class="center">
    <div class="home_section3_content">
    <?php
    	$section3_title = get_theme_mod('section3_title');
		$section3_title2 = get_theme_mod('section3_title2');
        if(!empty($section3_title)){
      ?>
	   <div class="smalltitle"><?php echo esc_attr($section3_title);?></div>
       <?php } 
        if(!empty($section3_title2)){
      ?>
      <div class="center-title">
        <h2><?php echo esc_attr($section3_title2); ?></h2>
      </div>
      <?php } ?>
      <div class="row_area">
			<?php 
			for($j=1; $j<10; $j++) { 
	  		if( get_theme_mod('third-column-left'.$j,false)) {
			$thirdblockbox = new WP_query('page_id='.get_theme_mod('third-column-left'.$j,true)); 
			while( $thirdblockbox->have_posts() ) : $thirdblockbox->the_post(); 
			?>
            <div class="hm-service-column">
              <div class="hm-service-column-inner">
				<?php if( has_post_thumbnail() ) { ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php the_post_thumbnail('full'); ?>
                </a>
                <?php } ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>">
                    <h3 class="hm-service-column-title"><?php the_title(); ?></h3>
                </a>
                <div class="hm-service-column-description">
                  <p><?php the_excerpt(); ?></p>
                </div>
              </div>
            </div>
			<?php endwhile; wp_reset_postdata(); 
               }} 
            ?>  
	        <div class="clear"></div>
      </div>
    </div>
  </div>
</section>
<?php } } ?>
<div class="clear"></div>
<div class="container">
     <div class="page_content">
      <?php 
	if ( 'posts' == get_option( 'show_on_front' ) ) {
    ?>
    <section class="site-main">
      <div class="blog-post">
        <?php
                    if ( have_posts() ) :
                        // Start the Loop.
                        while ( have_posts() ) : the_post();
                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                            get_template_part( 'content', get_post_format() );
                        endwhile;
                        // Previous/next post navigation.
						the_posts_pagination( array(
							'mid_size' => 2,
							'prev_text' => esc_html__( 'Back', 'skt-consulting' ),
							'next_text' => esc_html__( 'Next', 'skt-consulting' ),
						) );
                    else :
                        // If no content, include the "No posts found" template.
                         get_template_part( 'no-results', 'index' );
                    endif;
                    ?>
      </div>
      <!-- blog-post --> 
    </section>
    <?php
} else {
    ?>
	<section class="site-main">
      <div class="blog-post">
        <?php
                    if ( have_posts() ) :
                        // Start the Loop.
                        while ( have_posts() ) : the_post();
                            /*
                             * Include the post format-specific template for the content. If you want to
                             * use this in a child theme, then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
							 ?>
                             <header class="entry-header">           
            				<h1><?php the_title(); ?></h1>
                    		</header>
                             <?php
                            the_content();
                        endwhile;
                        // Previous/next post navigation.
						the_posts_pagination( array(
							'mid_size' => 2,
							'prev_text' => esc_html__( 'Back', 'skt-consulting' ),
							'next_text' => esc_html__( 'Next', 'skt-consulting' ),
						) );
                    else :
                        // If no content, include the "No posts found" template.
                         get_template_part( 'no-results', 'index' );
                    endif;
                    ?>
      </div>
      <!-- blog-post --> 
    </section>
	<?php
}
	?>
    <?php get_sidebar();?>
    <div class="clear"></div>
  </div><!-- site-aligner -->
</div><!-- content -->
<?php get_footer(); ?>