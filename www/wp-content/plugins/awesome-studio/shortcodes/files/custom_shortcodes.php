<?php
aw2_library::add_shortcode('aw2','shortcode', 'awesome2_custom_shortcode','Create a Shortcode');

function awesome2_custom_shortcode($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
		'main' => null,
		'desc' => null
		), $atts) );

	$pieces=explode('.',$main);
	$lib=$pieces[0];
	$tag=$pieces[1];
	aw2_library::add_shortcode($lib,$tag, 'aw2_execute_shortcode',$desc);
	aw2_library::$all_shortcodes[$lib . '.' . $tag]='aw2_execute_shortcode';
	$library=&aw2_library::get_array_ref('libraries',$lib);
	$library[$tag]['content']=$content;
	return;
}

function aw2_execute_shortcode($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	$pieces=explode('.',$shortcode);
	$library=aw2_library::get_array_ref('libraries',$pieces[0]);
	$shortcode_content=$library[$pieces[1]]['content'];
	
	$ss=&aw2_library::get_array_ref('shortcodes_stack');
	$new=array();
	$new['content']=$content;
	
	if($atts){
		foreach($atts as $key=>$value){
			$new[$key]=$value;
		}
	}
	$new['shortcode']=$shortcode;
	$ss[] = $new;
	$return_value=aw2_library::parse_shortcode($shortcode_content);	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	array_pop($ss);
	return $return_value;	
}
	
