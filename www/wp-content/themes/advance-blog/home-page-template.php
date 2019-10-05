<?php
/*
Template Name: Home Page Template
 *
 * @package Advance Blog
 * @since Advance Blog 1.0.4
 */
?>
<?php 
get_header();
    get_template_part('components/banner/banner', 'slider');
    get_template_part('components/banner/featured', 'category');
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

					<?php
					if ( get_query_var('paged') ) {
					    $paged = get_query_var('paged');
					} elseif ( get_query_var('page') ) { // 'page' is used instead of 'paged' on Static Front Page
					    $paged = get_query_var('page');
					} else {
					    $paged = 1;
					}

					$custom_query_args = array(
					    'post_type' => 'post', 
					    'posts_per_page' => get_option('posts_per_page'),
					    'paged' => $paged,
					    'post_status' => 'publish',
					    'ignore_sticky_posts' => true,
					    //'category_name' => 'custom-cat',
					    'order' => 'DESC', // 'ASC'
					    'orderby' => 'date' // modified | title | name | ID | rand
					);
					$custom_query = new WP_Query( $custom_query_args );

					if ( $custom_query->have_posts() ) : ?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					    while( $custom_query->have_posts() ) : $custom_query->the_post(); 
							get_template_part( 'components/post/content', get_post_format() );
					    endwhile;
					    ?>

					    <?php if ($custom_query->max_num_pages > 1) : // custom pagination  ?>
					        <?php
					        $orig_query = $wp_query; // fix for pagination to work
					        $wp_query = $custom_query;
					        ?>
					        	<nav class="navigation posts-navigation" role="navigation">
				        			<div class="nav-links">
				        				<div class="nav-previous">
				        					<?php 
				        					$older_post = __('Older Entries','advance-blog');
				        					$older_post_tag = get_next_posts_link( $older_post, $custom_query->max_num_pages );
				        					echo wp_kses_post($older_post_tag); ?>
				        				</div>
				        				<div class="nav-next">
				        					<?php 
				        					$newer_post = __('Newer Entries','advance-blog');
				        					echo wp_kses_post(get_previous_posts_link( $newer_post )); ?>
				        				</div>
				        			</div>
					        	</nav>
					        <?php
					        $wp_query = $orig_query; // fix for pagination to work
					        ?>
					    <?php endif; ?>

					<?php
					    wp_reset_postdata(); // reset the query 
					else:
					    get_template_part( 'components/post/content', 'none' );
					endif; ?>
		</main>
	</div>
	<?php
get_sidebar();
get_footer();