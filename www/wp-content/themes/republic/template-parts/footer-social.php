<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    echo '<ul class="social">';

    /* facebook */
    if( get_theme_mod('republic_facebook') ):
            echo '<a target="_blank" alt="Facebook" href="'.esc_url(get_theme_mod('republic_facebook','republic')).'"><i class="fa fa-facebook"></i></a>';
    endif;
    /* twitter */
    if(get_theme_mod('republic_twitter') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_twitter','republic')).'"><i class="fa fa-twitter"></i></a>';
    endif;
    /* googleplus */
    if(get_theme_mod('republic_googleplus') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_googleplus','republic')).'"><i class="fa fa-google-plus"></i></a>';
    endif;
    /* linkedin */
    if( get_theme_mod('republic_linkedin') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_linkedin','republic')).'"><i class="fa fa-linkedin"></i></a>';
    endif;
    /* dribbble */
    if(get_theme_mod('republic_dribbble') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_dribbble','republic')).'"><i class="fa fa-dribbble"></i></a>';
    endif;
    /* vimeo */
    if( get_theme_mod('republic_vimeo')):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_vimeo','republic')).'"><i class="fa fa-vimeo-square"></i></a>';
    endif;
    /* rss */
    if( get_theme_mod('republic_rss') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_rss','republic')).'"><i class="fa fa-rss"></i></a>';
    endif;
    /* instagram */
    if( get_theme_mod('republic_instagram') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_instagram','republic')).'"><i class="fa fa-instagram"></i></a>';
    endif;
    /* pinterest */
    if( get_theme_mod('republic_pinterest') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_pinterest','republic')).'"><i class="fa fa-pinterest"></i></a>';
    endif;
    /* youtube */
    if( get_theme_mod('republic_youtube')):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_youtube','republic')).'"><i class="fa fa-youtube"></i></a>';
    endif;
    /* skype */
    if( get_theme_mod('republic_skype') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_skype','republic')).'"><i class="fa fa-skype"></i></a>';
    endif;
    /* flickr */
    if( get_theme_mod('republic_flickr') ):
            echo '<a target="_blank" href="'.esc_url(get_theme_mod('republic_flickr','republic')).'"><i class="fa fa-flickr"></i></a>';
    endif;
    
    echo '</ul>';