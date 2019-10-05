<?php

aw2_library::add_shortcode('aw2','if', 'awesome2_if','Executes the statements if the conditions are true');
function awesome2_if($atts,$content=null,$shortcode){
	$cond=aw2_library::pre_actions('all',$atts,$content,$shortcode);
	extract( shortcode_atts( array(
		'main' => null
	), $atts) );
	
	$stack_id=aw2_library::push_child('if','if');
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);
	
	if($main){
		$check=aw2_library::get($main);
		if($check==false)
			$cond=false;
	}
	
	$return_value= '';
	
	if($cond==true){
		$status=true;
		$return_value= aw2_library::parse_shortcode($content);
	}
	else
		$status=false;
	
	$call_stack['status']=$status;	
	return aw2_library::post_actions('all',$return_value,$atts);
}

aw2_library::add_shortcode('aw2','else', 'awesome2_else');
function awesome2_else($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	$stack_id=aw2_library::last_child('if');
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);
	$status=$call_stack['status'];
	if($status)
		$return_value= '';
	else
		$return_value= aw2_library::parse_shortcode($content);

	aw2_library::pop_child($stack_id);
	return aw2_library::post_actions('all',$return_value,$atts);
}

aw2_library::add_shortcode('aw2','and', 'awesome2_and');
function awesome2_and($atts,$content=null,$shortcode){
	$cond=aw2_library::pre_actions('all',$atts,$content,$shortcode);
	extract( shortcode_atts( array(
		'main' => null
	), $atts) );

	if($main){
		$check=aw2_library::get($main);
		if($check==false)
			$cond=false;
	}
	
	$stack_id=aw2_library::last_child('if');
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);
	$status=$call_stack['status'];
	if(is_null($status)){
		aw2_library::set_error('And without If');
		return;
	}
	
	if($cond==true && $status==true){
		$status=true;
		$return_value= aw2_library::parse_shortcode($content);
	}
	else{
		$return_value= '';
		$status=false;
	}
	$call_stack['status']=$status;
	return aw2_library::post_actions('all',$return_value,$atts);
}


aw2_library::add_shortcode('aw2','or', 'awesome2_or');
function awesome2_or($atts,$content=null,$shortcode){
	$cond=aw2_library::pre_actions('parse_attributes',$atts,$content,$shortcode);
	extract( shortcode_atts( array(
		'main' => null
	), $atts) );

	if($main){
		$check=aw2_library::get($main);
		if($check==false)
			$cond=false;
	}

	$stack_id=aw2_library::last_child('if');
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);
	$status=$call_stack['status'];

	if(is_null($status)){
		aw2_library::set_error('or without If');
		return;
	}
	
	if($cond==true || $status==true){
		$status=true;
		$return_value= aw2_library::parse_shortcode($content);
	}
	else{
		$return_value= '';
		$status=false;
	}

	$call_stack['status']=$status;
	return aw2_library::post_actions('all',$return_value,$atts);

}

/* -----------------------------------------------------------------------------------------*/

aw2_library::add_shortcode('aw2' ,'yes', 'awesome2_true','If evaluates to true executes the statements');
aw2_library::add_shortcode('aw2' ,'true', 'awesome2_true','If evaluates to true executes the statements');
function awesome2_true($atts,$content=null,$shortcode){
	$cond=aw2_library::pre_actions('parse_attributes',$atts,$content,$shortcode);

	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );
	if($main){
		
		$check=aw2_library::get($main);
		if($check==false)
			$cond=false;
	}

	$return_value='';
	
	if($cond)
		$return_value=aw2_library::parse_shortcode($content);
		
	return aw2_library::post_actions('all',$return_value,$atts);
}

aw2_library::add_shortcode('aw2' ,'false', 'awesome2_false','If evaluates to false executes the statements');
aw2_library::add_shortcode('aw2' ,'no', 'awesome2_false','If evaluates to false executes the statements');
function awesome2_false($atts,$content=null,$shortcode){
	$cond=aw2_library::pre_actions('parse_attributes',$atts,$content,$shortcode);
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	if($main){
		$check=aw2_library::get($main);
		if($check==false)
			$cond=false;
	}

	$return_value='';
	
	if(!$cond)
		$return_value=aw2_library::parse_shortcode($content);
	
	return aw2_library::post_actions('all',$return_value,$atts);
}


aw2_library::add_shortcode('aw2','switch', 'awesome2_switch');
function awesome2_switch($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	$stack_id=aw2_library::push_child('switch','switch');
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);
	$call_stack['status']=true;	
	$return_value=aw2_library::parse_shortcode($content);
	aw2_library::pop_child($stack_id);
	return aw2_library::post_actions('all',$return_value,$atts);
}

aw2_library::add_shortcode('aw2','case', 'awesome2_case');
function awesome2_case($atts,$content=null,$shortcode){
	$cond=aw2_library::pre_actions('all',$atts,$content,$shortcode);

	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	if($main){
		$check=aw2_library::get($main);
		if($check==false)
		$cond=false;
	}

	$stack_id=aw2_library::last_child('switch');
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);
	$status=$call_stack['status'];
	
	if(is_null($status)){
		aw2_library::set_error('Case without Switch');
		return;
	}
	$return_value='';
	if($cond==true && $status==true){
		$call_stack['status']=false;
		$return_value= aw2_library::parse_shortcode($content);
	}
	
	return aw2_library::post_actions('all',$return_value,$atts);
}

aw2_library::add_shortcode('aw2','case_else', 'awesome2_case_else');
function awesome2_case_else($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	$return_value='';
	$stack_id=aw2_library::last_child('switch');
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);
	$status=$call_stack['status'];
	
	if(is_null($status)){
		aw2_library::set_error('Case without Switch');
		return;
	}
	
	if($status){
		$call_stack['status']=false;
		$return_value= aw2_library::parse_shortcode($content);
	}
	return aw2_library::post_actions('all',$return_value,$atts);
}


aw2_library::add_shortcode('aw2' ,'empty', 'awesome2_empty','If evaluates to empty executes the statements');
function awesome2_empty($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;

	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	$check=aw2_library::get($main);
	$return_value='';
	
	if(empty($check))
		$return_value=aw2_library::parse_shortcode($content);
		
	return aw2_library::post_actions('all',$return_value,$atts);
}

aw2_library::add_shortcode('aw2' ,'not_empty', 'awesome2_not_empty','If evaluates to empty executes the statements');
function awesome2_not_empty($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	$check=aw2_library::get($main);

	$return_value='';
	if(!empty($check))
		$return_value=aw2_library::parse_shortcode($content);
		
	return aw2_library::post_actions('all',$return_value,$atts);
}


aw2_library::add_shortcode('aw2' ,'whitespace', 'awesome2_whitespace','If evaluates to whitespace executes the statements');
function awesome2_whitespace($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;

	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	$check=aw2_library::get($main);
	$return_value='';
	
	if (ctype_space($check) || $check == '')
		$return_value=aw2_library::parse_shortcode($content);
		
	return aw2_library::post_actions('all',$return_value,$atts);
}

aw2_library::add_shortcode('aw2' ,'not_whitespace', 'awesome2_not_whitespace','If does not evaluate to whitespace executes the statements');
function awesome2_not_whitespace($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );

	$check=aw2_library::get($main);

	$return_value='';

	if (!(ctype_space($check) || $check == ''))
		$return_value=aw2_library::parse_shortcode($content);
		
	return aw2_library::post_actions('all',$return_value,$atts);
}



aw2_library::add_shortcode('aw2' ,'equal', 'awesome2_equal','Checks if both the values are equal');
function awesome2_equal($atts,$content=null,$shortcode){
	$atts['cond']=$atts[0];	unset($atts[0]);
	$atts['equal']=$atts[1];unset($atts[1]);
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	$return_value=aw2_library::parse_shortcode($content);
	return aw2_library::post_actions('all',$return_value,$atts);
}




aw2_library::add_shortcode('aw2' ,'not_equal', 'awesome2_not_equal','Checks if both the values are not equal');
function awesome2_not_equal($atts,$content=null,$shortcode){
	$atts['cond']=$atts[0];	unset($atts[0]);
	$atts['not_equal']=$atts[1];unset($atts[1]);
	
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	$return_value=aw2_library::parse_shortcode($content);
	return aw2_library::post_actions('all',$return_value,$atts);
}

aw2_library::add_shortcode('aw2' ,'part', 'awesome2_part','Checks if part is there in request');
function awesome2_part($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );
	
	$return_value='';
	$done=false;
	$part=aw2_library::get('request.part');	
	if($part==$main){
		$done=true;
		$return_value= aw2_library::parse_shortcode($content);
	}
	if($part=='' && $main=='default'){
		$return_value= aw2_library::parse_shortcode($content);
	}
	return aw2_library::post_actions('all',$return_value,$atts);	
}
