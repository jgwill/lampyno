<?php
aw2_library::add_shortcode('aw2','echo', 'awesome2_echo','Echo Something');
function awesome2_echo($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );
	$return_value=aw2_library::get($main,$atts,$content);
	util::var_dump($return_value);	
	return;
}


aw2_library::add_shortcode('aw2','set', 'awesome2_set','Set a Variable');
function awesome2_set($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	'overwrite'=>'yes',
	'default'=>'',
	'assume_empty' => null,
	'main'=>null
	), $atts) );
	
	unset($atts['assume_empty']);
	unset($atts['overwrite']);
	unset($atts['default']);
	unset($atts['main']);
	
	if($main){
		aw2_library::set($main,null,$content,$atts);
	}	
	
	foreach ($atts as $loopkey => $loopvalue) {
		$newvalue=$loopvalue;
		if($loopvalue==$assume_empty)$newvalue='';
		if($loopvalue=='' || $loopvalue==null)$newvalue=$default;
		aw2_library::set($loopkey,$newvalue,null,$atts);
	}
	return;
}

aw2_library::add_shortcode('aw2','set_array', 'awesome2_set_array','Set elements of an Array');
function awesome2_set_array($atts,$content=null,$shortcode){
		if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	'main'=>null,
	'with'=>null
	), $atts) );
	
	unset($atts['main']);
	unset($atts['with']);
	
	if(aw2_library::endswith($main, '.new')){
		aw2_library::set($main,null);	
		$path=substr($main, 0, -4);
		foreach ($atts as $loopkey => $loopvalue) {
			aw2_library::set($path . '.last.' . $loopkey,$loopvalue);
		}
		if($content)
			aw2_library::set($path . '.last.' . 'content',$content);
			
	}
	else{
		foreach ($atts as $loopkey => $loopvalue) {
			aw2_library::set($main . '.' . $loopkey,$loopvalue);
		}
		if($content)
			aw2_library::set($main . '.' . 'content',$content);

	}
	return;
}


aw2_library::add_shortcode('aw2','get', 'awesome2_get');
function awesome2_get($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	'main'=>null,
	'default'=>''
	), $atts, 'aw2_get' ) );
	

	$return_value=aw2_library::get($main,$atts,$content);
	
	if($return_value==='')
		$return_value=$default;
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	if(is_object($return_value))
		$return_value='Object';
	return $return_value;
}



aw2_library::add_shortcode('aw2','raw', 'awesome2_raw');
function awesome2_raw($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
	), $atts) );
	

	$return_value=aw2_library::get('raw',$atts,$content);
	
	if($return_value==='')
		$return_value=$default;
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	if(is_object($return_value))
		$return_value='Object';
	return $return_value;
}

aw2_library::add_shortcode('aw2','model', 'awesome2_model');
function awesome2_model($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	$return_value=$content;
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	if(is_object($return_value))$return_value='Object';
	return $return_value;
}

aw2_library::add_shortcode('aw2','ignore', 'awesome2_ignore','Ignore everything inside');
function awesome2_ignore($atts,$content=null,$shortcode){
	return;
}

aw2_library::add_shortcode('aw2','die', 'awesome2_die','Die');
function awesome2_die($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	if($content)echo aw2_library::parse_shortcode($content);
	die();
}

aw2_library::add_shortcode('aw2' ,'do', 'awesome2_do','Parses whatever is inside');
function awesome2_do($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	$return_value = aw2_library::parse_shortcode($content);
	$return_value = aw2_library::post_actions('all',$return_value,$atts);
	
	return $return_value;
}
