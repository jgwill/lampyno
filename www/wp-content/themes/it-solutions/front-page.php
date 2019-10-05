<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package IT Solutions
 */
get_header(); 

$hideslide = get_theme_mod('hide_slides', 1);
$secwithcontent = get_theme_mod('hide_home_secwith_content', 1);
$hidesectwo = get_theme_mod('hide_sectiontwo', 1);
$hidesecthree = get_theme_mod('hide_hm3_content', 1);

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
          $it_solutions_slideno[] = $i;
          $it_solutions_slidetitle[] = get_the_title();
		  $it_solutions_slidedesc[] = get_the_excerpt();
          $it_solutions_slidelink[] = esc_url(get_permalink());
          ?>
          <img src="<?php the_post_thumbnail_url('full'); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" />
          <?php
        $sld++;
        endwhile;
          ?>
    </div>
        <?php
        $k = 0;
        foreach( $it_solutions_slideno as $it_solutions_sln ){ ?>
    <div id="slidecaption<?php echo esc_attr( $it_solutions_sln ); ?>" class="nivo-html-caption">
      <div class="slide_info">
        <h2><?php echo esc_html($it_solutions_slidetitle[$k] ); ?></h2>
        <p><?php echo esc_html($it_solutions_slidedesc[$k] ); ?></p>
        <div class="clear"></div>
        <a class="slide_more" href="<?php echo esc_url($it_solutions_slidelink[$k] ); ?>">
          <?php esc_html_e('Read More', 'it-solutions');?>
          </a>
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

	if(!is_home() && is_front_page()){ 
	if( $secwithcontent == '') {
?>
 <section id="sectionone">
 	<div class="container">
      <div class="home_section1_content">
        <div class="row_area">	
			<?php 
			for($l=1; $l<5; $l++) { 
	  		if( get_theme_mod('sec-column-left'.$l,false)) {
			$leftblock = new WP_query('page_id='.get_theme_mod('sec-column-left'.$l,true)); 
			while( $leftblock->have_posts() ) : $leftblock->the_post(); 
			?>
			<div class="servicebox boxpattern-1">
				<div class="serviceboxbg">
                	<?php
                	if ( has_post_thumbnail() ) {
					?>
                	<div class="servicebox-icon"><?php the_post_thumbnail('full'); ?></div>
                    <?php } ?>
                    <div class="servicebox-content">
                    <a href="<?php echo esc_url( get_permalink() ); ?>"><h3><?php the_title(); ?></h3></a>
                    <p><?php the_excerpt(); ?></p></div>
                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="serv-read"><?php esc_html_e('READ MORE', 'it-solutions');?></a>
				</div>
			</div>
			<?php endwhile; wp_reset_postdata(); 
               }} 
            ?>             
</div>
      </div>
    </div>
 </section>
<?php }} ?>
<?php
if (!is_home() && is_front_page()) { 
if( $hidesectwo == '') { ?>
<section class="home2_section_area ">
    	<div class="center">
            <div class="home_section2_content">
         	 <?php 
	  		if( get_theme_mod('page-column1',false)) {
			$sectiontwoquery = new WP_query('page_id='.get_theme_mod('page-column1',true)); 
			while( $sectiontwoquery->have_posts() ) : $sectiontwoquery->the_post(); ?>
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?> 
          	<?php endwhile;
       		wp_reset_postdata(); 
	   		} ?>
            </div>
        </div>
    </section>
<?php } } ?>  
<?php
if (!is_home() && is_front_page()) { 
if( $hidesecthree == '') { ?>
<section class="home3_section_area">
    	<div class="center">
            <div class="home_section3_content">
			<?php
            $section3_title = get_theme_mod('section3_title');
            if(!empty($section3_title)){
            ?>
            <div class="center-title">
            <h2><?php echo esc_attr($section3_title); ?></h2>
            </div>
            <?php }
            ?>  
          	<div class="row_area">
	        <?php 
				for($sc=1; $sc<7; $sc++) { 
				if( get_theme_mod('sec3-bx'.$sc,false)) {
				$homesecthree = new WP_query('page_id='.get_theme_mod('sec3-bx'.$sc,true)); 
				while( $homesecthree->have_posts() ) : $homesecthree->the_post(); 
			?>
            <div class="featuresbox"> <a href="<?php echo esc_url( get_permalink() ); ?>">
              <div class="featuresbox-area">
                <?php
                if ( has_post_thumbnail() ) {
				?>
                <div class="features-thumb"><?php the_post_thumbnail('full'); ?></div>
                <?php } ?>
                <div class="features-title">
                  <h4><?php the_title(); ?></h4>
                </div>
                <div class="features-description"><?php the_excerpt(); ?></div>
              </div>
              </a></div>
             <?php endwhile; wp_reset_postdata(); 
               }} 
            ?>     
              <div class="clear"></div>
          </div>
        </div>
        </div>
    </section>
                  <div class="clear"></div>
<?php } } ?>  
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
							'prev_text' => esc_html__( 'Back', 'it-solutions' ),
							'next_text' => esc_html__( 'Next', 'it-solutions' ),
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
							'prev_text' => esc_html__( 'Back', 'it-solutions' ),
							'next_text' => esc_html__( 'Next', 'it-solutions' ),
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