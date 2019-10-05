<?php
/**
 * Template Name: Idyllic Corporate Template
 *
 * Displays Corporate template.
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
get_header();
$idyllic_settings = idyllic_get_theme_options(); ?>
<main id="main" class="site-main" role="main">
<?php
/********************************************************************/
if($idyllic_settings['idyllic_frontpage_position'] =='default'){
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_fact_figure_box');
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_our_testimonial');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_team_member');
	}elseif($idyllic_settings['idyllic_frontpage_position'] =='design_second_position_display'){
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_fact_figure_box');
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_our_testimonial');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_team_member');
	}elseif($idyllic_settings['idyllic_frontpage_position'] =='design_third_position_display'){
		do_action('idyllic_display_fact_figure_box');
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_our_testimonial');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_team_member');
	}elseif($idyllic_settings['idyllic_frontpage_position'] =='design_fourth_position_display'){
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_fact_figure_box');
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_our_testimonial');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_team_member');
	}elseif($idyllic_settings['idyllic_frontpage_position'] =='design_fifth_position_display'){
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_fact_figure_box');
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_our_testimonial');
		do_action('idyllic_display_team_member');
	}elseif($idyllic_settings['idyllic_frontpage_position'] =='design_sixth_position_display'){
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_fact_figure_box');
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_team_member');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_our_testimonial');
	}elseif($idyllic_settings['idyllic_frontpage_position'] =='design_seventh_position_display'){
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_team_member');
		do_action('idyllic_display_our_testimonial');
		do_action('idyllic_display_fact_figure_box');
	}elseif($idyllic_settings['idyllic_frontpage_position'] =='design_eigth_position_display'){
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_team_member');
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_our_testimonial');
		do_action('idyllic_display_fact_figure_box');
	}elseif($idyllic_settings['idyllic_frontpage_position'] =='design_ninth_position_display'){
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_team_member');
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_our_testimonial');
		do_action('idyllic_display_fact_figure_box');
	}
	elseif($idyllic_settings['idyllic_frontpage_position'] =='design_tenth_position_display'){
		do_action('idyllic_display_front_page_features');
		do_action('idyllic_display_portfolio_box');
		do_action('idyllic_display_about_us');
		do_action('idyllic_display_latest_from_blog_box');
		do_action('idyllic_display_team_member');
		do_action('idyllic_display_fact_figure_box');
		do_action('idyllic_display_our_testimonial');
	}
		the_content();

		if(class_exists('Idyllic_Plus_Features')){
			do_action('idyllic_client_box');
		} ?>
</main><!-- end #main -->
<?php
get_footer();