<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
	function republic_slider(){
	?>
<ul class="" data-orbit data-orbit data-options="animation_speed:500; bullets:false; slide_number: false; pause_on_hover: false;timer_speed: 5000;">
	<?php 
     $sa= get_theme_mod('republic_slider_range');
     $i = 1;
        while($i < $sa)
        {
        echo '<li>';
        echo ' <img src="'. get_theme_mod('slide_image'.$i). '" alt="'.get_theme_mod('slide_caption'.$i).'" /><div class="orbit-caption">'.get_theme_mod('slide_caption'.$i).'</div>';
        echo "</li>";
        $i++;
        } 
        echo '</ul>';
}
?>