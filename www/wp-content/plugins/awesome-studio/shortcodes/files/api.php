<?php

add_shortcode('api', 'awesome2_api');

function awesome2_api($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts(array(
	'main'=>null,
	'args'=>null,
	'api_data'=>null,
	'echo_and_die'=>null
	), $atts) );

	$a=array();
	if($args)$a=$args;
	unset($atts['args']);
	unset($atts['main']);
	unset($atts['api_data']);

	if($api_data)aw2_library::set('api_data',$api_data);	
	
	if($content){
		$array=awesome2_array(array('api'=>'yes'),$content,null);
		if(isset($array['api_data']))aw2_library::set('api_data',$array['api_data']);		
		if(isset($array['args']))$a=array_merge_recursive($a,$array['args']);
	}

	foreach ($atts as $key => $value) {
		$a[$key]=$value;
	}

	$new_atts=array();
	$new_atts['args']=$a;
	
	if($echo_and_die){
		echo '<br />------args --------';
		util::var_dump($a);
		echo '<br />------api_data --------';		
		util::var_dump($array['api_data']);
		echo '<br />';
		die();
	}
	$content='';
	
	$return_value=aw2_library::run_api($main,$new_atts,$content);
	
	if(is_string($return_value))$return_value=trim($return_value);
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	aw2_library::set('api_data',null);
		
	return $return_value;
}	


aw2_library::add_shortcode('api','call', 'awesome2_api_call', 'Call an API');

function awesome2_api_call($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts(array(
	'main'=>null,
	'args'=>null,
	'api_data'=>null,
	'echo_and_die'=>null
	), $atts) );

	$a=array();
	if($args)$a=$args;
	unset($atts['args']); 
	unset($atts['main']);
	unset($atts['api_data']);

	if($api_data)aw2_library::set('api_data',$api_data);	
	
	if($content){
		$array=awesome2_array(array('api'=>'yes'),$content,null);
		if(isset($array['api_data']))aw2_library::set('api_data',$array['api_data']);		
		if(isset($array['args']))$a=array_merge_recursive($a,$array['args']);
	}

	foreach ($atts as $key => $value) {
		$a[$key]=$value;
	}

	$new_atts=array();
	$new_atts['args']=$a;
	
	if($echo_and_die){
		echo '<br />------args --------';
		util::var_dump($a);
		echo '<br />------api_data --------';		
		util::var_dump($array['api_data']);
		echo '<br />';
		die();
	}

	$content='';
	
	$return_value=aw2_library::run_api($main,$new_atts,$content);
	
	if(is_string($return_value))$return_value=trim($return_value);
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
		
	return $return_value;

}	

aw2_library::add_shortcode('api','include', 'awesome2_api_include', 'Include a Module from an API');

function awesome2_api_include($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts(array(
	'main'=>null,
	'args'=>null
	), $atts) );

	$a=array();
	if($args)$a=$args;
	unset($atts['args']);
	unset($atts['main']);
	
	foreach ($atts as $key => $value) {
		$args[$key]=$value;
	}
	$new_atts=array();
	$new_atts['args']=$args;

	
	$return_value=aw2_library::run_api($main,$new_atts,$content,'include');
	
	if(is_string($return_value))$return_value=trim($return_value);
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	return $return_value;
}	



aw2_library::add_shortcode('api','set_callback', 'awesome2_api_set_callback', 'Set the Callback for the API');
function awesome2_api_set_callback($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts(array(
	'callback_api'=>null
	), $atts) );
	$o=new stdClass();
	aw2_library::get_aw2_secret($o);
	$callback=$o->value;
	$callback['api']=$callback_api;
	$callback['route_ajax']='callback/' . $callback['secret'];
	
	aw2_library::set('module.callback',$callback);
	$data['callback']=	$callback;
	$data['on_submit']=	aw2_library::get('module.args.on_submit');
	$data['api_data']=	aw2_library::get('api_data');
	$save=json_encode($data);
	add_option( $callback['token'], $save, '', 'no' );
}	




function args_set($atts,$content=null,$shortcode){

	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	if($main){
		aw2_library::set('_args.' . $main,null,$content,$atts);
	}
	unset($atts['main']);
	foreach ($atts as $loopkey => $loopvalue) {
		aw2_library::set('_args.' . $loopkey,$loopvalue,null,$atts);
	}
	return;
}	

aw2_library::add_shortcode('args','array_push', 'args_array_push','Set array Arguments for a Module or Template');
function args_array_push($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	unset($atts['main']);

	aw2_library::set('_args.' . $main . '.new',null);	
	foreach ($atts as $loopkey => $loopvalue) {
		aw2_library::set('_args.' . $main . '.last.' . $loopkey,$loopvalue);
	}
	return;

}	

aw2_library::add_shortcode('args','save', 'args_save','Save the args to the options table');
function args_save($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );
	
	$token='args_' . aw2_library::get('token');
	add_option( $token, aw2_library::get($main . '.args'), '','no');
	aw2_library::set($main . '.args_token',$token);
	return $token;	
}	

aw2_library::add_shortcode('args','load', 'args_load','Load the args from the Options Table');
function args_load($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null,
	'token'=>null
	), $atts) );
	if(!$token)
		$token=aw2_library::get($main . '.args_token');
	$option=get_option($token);
	aw2_library::set($main . '.args',$option);
	return;
}	

aw2_library::add_shortcode('args','merge_defaults', 'args_merge_defaults','Merge the defaults with the options');

function args_merge_defaults($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null,
	), $atts) );
	
	$base=aw2_library::get($main . '.defaults');
	if(!$base)return;
	$args=aw2_library::get($main . '.args');
	$new=array_replace_recursive($base, $args);
	aw2_library::set($main . '.args',$new);
	return;
}	

