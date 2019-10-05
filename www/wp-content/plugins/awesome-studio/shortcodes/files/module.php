<?php

add_shortcode('aw2.module', 'awesome2_module');
aw2_library::add_shortcode('aw2','module', 'awesome2_module','Call a Module');
function awesome2_module($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
 	extract( shortcode_atts( array(
		'main'=>'run',
		'slug' =>null,
		'template'=>null,
		'post_type'=>null
	), $atts) );

	$return_value=aw2_library::run_module($slug,$template,$content,$atts,$post_type,$main);
	if(is_string($return_value))
		$return_value=trim($return_value);
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	if(is_object($return_value))
		$return_value='Object';
	return $return_value;
}

aw2_library::add_shortcode('aw2','template', 'awesome2_template', 'Set a Template');
function awesome2_template($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'global'=>false,
	'main'=>null
	), $atts) );
	
	if($global){
		$template_def=new template_def($main,$content);
		aw2_library::set($main,$template_def);
	}
	else{
		$post_type_slug=aw2_library::get('module.post_type_slug');
		$modules=aw2_library::get_array_ref('modules');
		$module_def=$modules[$post_type_slug];
		$template_def=new template_def($main,$content,$module_def);
		aw2_library::set('modules.' . $post_type_slug . '.templates.' . $main,$template_def);
	}	
	$load=aw2_library::get('module.load');
	if($load){
		$template_def=new template_def($main,$content);
		aw2_library::set($main,$template_def);
	}
}



aw2_library::add_shortcode('aw2','return', 'awesome2_return', 'Return a Value from a Template or Module');
function awesome2_return($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );
	
	$return_value=aw2_library::get($main,$atts,$content);
	aw2_library::set('_return',$return_value);
	return;
}


add_shortcode('aw2.this', 'awesome2_this');
aw2_library::add_shortcode('aw2','this', 'awesome2_this','Set Module Parameters');
function awesome2_this($atts,$content=null,$shortcode){

	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	if($main){
		aw2_library::set('this.' . $main,null,$content,$atts);
	}
	unset($atts['main']);
	foreach ($atts as $loopkey => $loopvalue) {
		aw2_library::set('this.' . $loopkey,$loopvalue,null,$atts);
	}
	return;
}	


aw2_library::add_shortcode('aw2','run', 'awesome2_run', 'Run a Module or a Template');
function awesome2_run($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null,
	'slug'=>null,
	'template'=>null,
	'module'=>null,
	'post_type'=>null
	), $atts ) );
	
	if($module || $slug || $template || $post_type){
		if($module)$slug=$module;
		$return_value=aw2_library::run_module($slug,$template,$content,$atts,$post_type,'run');
	}
	else{
		$exists=aw2_library::get($main . '.exists',$atts,$content);
		if($exists===true){
			$return_value=aw2_library::get($main . '.run',$atts,$content);
		}
		else{
			$return_value=$main . 'Module or Template' . $main . ' Not Found';
		}
	}
	
	if(is_string($return_value))
		$return_value=trim($return_value);
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	if(is_object($return_value))
		$return_value='Object';
	return $return_value;
}


	
aw2_library::add_shortcode('aw2','include', 'awesome2_include', 'Include a Module');
function awesome2_include($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'slug'=>null,
	'post_type'=>null,
	'template'=>null
	), $atts ) );
	$return_value=aw2_library::run_module($slug,$template,$content,$atts,$post_type,'include');
	if(is_string($return_value))
		$return_value=trim($return_value);
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	return $return_value;

	
}


aw2_library::add_shortcode('aw2','load', 'awesome2_load', 'Load a Module or a Template');
function awesome2_load($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null,
	'slug'=>null,
	'post_type'=>null,
	'template'=>null
	), $atts ) );
	
	if($slug){
		$module_def=new module_def();
		$module_def->create_from_local($slug,$post_type);
		$module_def->load='yes';
		$module_def->run($atts);
		
		if($template)
			$return_value=aw2_library::get($template . '.run',$atts,$content);
	}
	else{
		$atts['load']='yes';
		$return_value=aw2_library::get($main . '.run',$atts,$content);
	}
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	return $return_value;
}


aw2_library::add_shortcode('aw2','new', 'awesome2_new', 'Create an instance of a Module');
function awesome2_new($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null,
	'as'=>null,
	
	), $atts ) );
	unset($atts['as']);
	
	aw2_library::get($main . '.instance.' . $as,$atts,$content);
	
	return ;
}

add_shortcode('aw2.cdn', 'awesome2_cdn');
aw2_library::add_shortcode('aw2','cdn', 'awesome2_cdn','Call a CDN Module');
function awesome2_cdn($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	$return_value=aw2_library::run_cdn($atts,$content);
	if(is_string($return_value))
		$return_value=trim($return_value);
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	return $return_value;
}


aw2_library::add_shortcode('aw2','trigger', 'awesome2_run_trigger','Execute the triggers based on when');
function awesome2_run_trigger($atts,$content=null,$shortcode){
	$return_value='';
	
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
 	extract( shortcode_atts( array(
		'when' =>null,
		'global'=>false,
		'slug' =>null
	), $atts) );
	
	if(!empty($slug)){
	
		//get post from global trigger and execute
		if(aw2_library::get_post_from_slug( $slug,'aw2_trigger',$module_post)){
			$return_value = trim(aw2_library::parse_shortcode($module_post->post_content));
		}
		return $return_value;
	}
	awesome2_trigger::load_app();
	if($global == "true"){
		awesome2_trigger::load();
	}
	
	
	
	$return_value=trim(awesome2_trigger::return_trigger_output($when));
	
	return $return_value;
}
