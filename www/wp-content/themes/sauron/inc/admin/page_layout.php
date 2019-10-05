<?php
class WDWT_layout_page_class{
  public $options;

  function __construct(){
    
    $this->options = array(
      'full_width' => array( 
      "name" => "full_width", 
      "title" => __( "Full Width", "sauron"),
      'type' => 'checkbox_open', 
      "sanitize_type" => "sanitize_text_field",
      "description" => __( "Default layout. Check to have full width content. Uncheck to have boxed layout.", "sauron"),
      'show' => array(''),
      'hide' => array('content_area_percent'),
      'section' => 'layouts', 
      'tab' => 'layout_editor',
      'default' => true,
      'customizer' => array()
    ),      
    'content_area_percent' => array( 
      "name" => "content_area_percent",
      "title" => __("Box Width", "sauron"), 
      'type' => 'number',
      "sanitize_type" => "sanitize_text_field",  
      "description" => __("Specify the width of the Content area if boxed layout", "sauron"),
      'unit_symbol' => '%',
      'step' => '1',
      'min' => '75',
      'max' => '99',
      'section' => 'layouts', 
      'tab' => 'layout_editor',
      'default' => '75',
      'customizer' => array()
      ),

      'default_layout' => array(
        "name" => "default_layout", 
        "title" => __("Choose Default Layout of Content", "sauron"), 
        'type' => 'layout_open', 
        "description" => __( "Select the default layout for pages and posts on the website.", "sauron" ), 
        'valid_options' => array( 
          array('index' => '1', 'title'=>'No Sidebar', 'description'=>''),
          array('index' => '2', 'title'=>'Right Sidebar', 'description'=>''),
          array('index' => '3', 'title'=>'Left Sidebar', 'description'=>''),
          array('index' => '4', 'title'=>'Two Right Sidebars', 'description'=>''),
          array('index' => '5', 'title'=>'Two Left Sidebars', 'description'=>''),
          array('index' => '6', 'title'=>'One Right One Left Sidebars', 'description'=>''),

        ),
        'show' => array(
                      '2'=>'main_column',
                      '3'=>'main_column',
                      '4'=>array('main_column', 'pwa_width'),
                      '5'=>array('main_column', 'pwa_width'),
                      '6'=>array('main_column', 'pwa_width'),
                      ),
        'hide' => array(),
        'img_src' => 'sprite-layouts.png',
        'img_height' => 289,
        'img_width' => 50,
        'section' => 'layouts',
        'tab' => 'layout_editor', 
        'default' => '1',
        'customizer' => array()
      ), 
    
    'main_column' => array( 
        "name" => "main_column", 
        "title" => __("Main Column Width", "sauron"), 
        'type' => 'number',
        "sanitize_type" => "sanitize_text_field",  
        "description" => __("Specify the width of the Main Column", "sauron"),
        'unit_symbol' => '%',
        'step' => '1',
        'min' => '1',
        'max' => '100',
        'section' => 'layouts', 
        'tab' => 'layout_editor',
        'default' => 67,
        'customizer' => array()
      ),
      'pwa_width' => array( 
        "name" => "pwa_width", 
        "title" => __("Primary Widget Area width", "sauron"), 
        'type' => 'number',
        "sanitize_type" => "sanitize_text_field",  
        "description" => __("Specify the width of the Primary Widget Area", "sauron"),
        'unit_symbol' => '%',
        'step' => '1',
        'min' => '1',
        'max' => '1000',
        'section' => 'layouts', 
        'tab' => 'layout_editor',
        'default' => 16,
        'customizer' => array()
      ),

    );
        
      
  
  }

  
  
}
 