<?php /**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */ ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php
        wp_head();
        ?>
    </head>
    <body <?php body_class() ?>>

    <?php 
  $header_text_color = get_header_textcolor();?>
  <!-- "The color of the text inside the header is #". $header_text_color . ".";  -->
  <!-- <div>
  <h3 style="color:(<?php echo $header_text_color; ?>)">this is header </h3>
  </div> -->

        <!--Start Header Wrapper-->
        <div class="header_wrapper">
        <?php $url= has_header_image() ? get_header_image() : get_theme_support("custom-header","default-image"); ?>
            <div class="header" style="background:url(<?php echo esc_url($url); ?>)">
                <!--Start Container-->
                <div class="container_24">
                    <div class="grid_24">
                        <div class="logo"> <a href="<?php echo esc_url(home_url()); ?>"><img src="<?php if (business_directory_get_option('business_directory_logo') != '') { ?><?php echo esc_url(business_directory_get_option('business_directory_logo')); ?><?php
                                } else {
                                    echo esc_url(get_template_directory_uri() . '/images/logo.png');
                                }
                                ?>" alt="<?php bloginfo('name'); ?>" /></a></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!--End Container-->
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <!--Start Menu Wrapper-->
            <div class="menu_wrapper">
                <div class="top_arc"></div>
                <div class="menu-container">
                    <div class="container_24">
                        <div class="grid_24">
                            <?php business_directory_nav(); ?> 
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div class="bottom_arc"></div>
            </div>
            <!--End Container-->
            <div class="clear"></div>
        </div>
        <!--End Header Wrapper-->
        <div class="clear"></div>
        <div class="wrapper">
            <!--Start Container-->
            <div class="container_24">
                <div class="grid_24">