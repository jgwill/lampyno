<?php

global $widget_list;
class aw2_widget_class extends WP_Widget {
     
	function __construct($value) {
			 parent::__construct(
			$value['id'],
			$value['name'],
			array (
				'description' => $value['description']
			)
		);
		 
	}
     
    function form( $instance ) {
		$instance['id_base']=$this->id_base;
		$instance['number']=$this->number;
		echo aw2_library::get('modules.' . $this->id_base . '.form.run',$instance);
    }
     
    function update( $new_instance, $old_instance ) {       
		$instance = $old_instance;
		foreach ($new_instance as $key => $value){
			$instance[$key]= strip_tags($value);
		}
		return $instance;
	}
     
    function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		echo aw2_library::get('modules.' . $this->id_base . '.widget.run',$instance);
		echo $args['after_widget'];
    }
     
}


function aw2_widgets_init() {
	 $widgets=aw2_library::get('widgets');
	 if(is_array($widgets)){
		 foreach($widgets as $value){
			 $w=new aw2_widget_class($value);
			 $w->_register();
		 }
	 }
}
add_action( 'widgets_init', 'aw2_widgets_init' );
