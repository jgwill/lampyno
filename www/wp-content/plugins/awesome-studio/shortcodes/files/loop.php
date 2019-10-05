<?php

aw2_library::add_shortcode('aw2','loop', 'awesome2_loop','Loops through an array');

function awesome2_loop($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
		'main' => null,
		), $atts) );
	$stack_id=aw2_library::push_child('loop',$main);
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);
	$items=aw2_library::get($main);

	if(!is_array($items) && !is_object($items)){
		aw2_library::set_error('Loop Element is not an Array:' . $main);
		return;
	}

	$call_stack['source']=$items;
	$call_stack['count']=count($items);
	
	$index=1;
	$string=null;
	foreach ($items as $key =>&$item) {
		$call_stack['index']=$index;
		$call_stack['counter']=$index-1;
		$call_stack['item']=&$item;
		$call_stack['key']=$key;
		$string=$string . aw2_library::parse_shortcode($content);
		$index++;
	}
	aw2_library::pop_child($stack_id);	
	$return_value=aw2_library::post_actions('all',$string,$atts);
	return $return_value;
}


aw2_library::add_shortcode('aw2','for', 'awesome2_for','throw out numbers from start to stop with increment');

function awesome2_for($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	
	extract( shortcode_atts( array(
		'start' => null,
		'stop' => null,
		'step' => 1
		), $atts) );

	$id=aw2_library::get_rand(3);	
	$stack_id=aw2_library::push_child('loop',$id);
	$call_stack=&aw2_library::get_array_ref('call_stack',$stack_id);

	$index=1;
	$call_stack['start']=$start;
	$call_stack['stop']=$stop;
	$call_stack['step']=$step;
	
	$string=null;
	$current=$start;
	
	if($stop>=$start){
		for ($i = $start; $i <= $stop; $i+=$step) {
			$call_stack['index']=$index;
			$call_stack['counter']=$index-1;
			$call_stack['item']=$i;
			$string=$string . aw2_library::parse_shortcode($content);
			$index++;
		}	
	}
	else{
		for ($i = $start; $i >= $stop; $i=$i-$step) {
			$call_stack['index']=$index;
			$call_stack['counter']=$index-1;
			$call_stack['item']=$i;
			$string=$string . aw2_library::parse_shortcode($content);
			$index++;
		}	
	}
		
	aw2_library::pop_child($stack_id);	
	return $string;
}


