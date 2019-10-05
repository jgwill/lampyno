<?php
aw2_library::add_shortcode('aw2','spa', 'awesome2_spa','Client side Actions');

function awesome2_spa($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;

	$string='';
    foreach ($atts as $key => $value) {
            $string .= ' data-' . $key . "='" . $value . "'";
    }

    return "<script type='text/spa' " . $string . ">" . aw2_library::parse_shortcode($content) . "</script>";
}


aw2_library::add_shortcode('aw2','client', 'awesome2_client','Throw out Scripts and styles');

function awesome2_client($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	'main'=>null
	), $atts ) );
	
	$return_value=aw2_library::get('client.' . $main,$atts,$content);
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	return $return_value;
}


aw2_library::add_shortcode('aw2','enqueue', 'awesome2_enqueue','Enqueue a Script or Style');

function awesome2_enqueue($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;

	if(array_key_exists('script',$atts))	
		wp_enqueue_script($atts['handle'],$atts['script'],false,null,true);
	else
		wp_enqueue_style($atts['handle'],$atts['style'],false,null);
	
	return;	
}
