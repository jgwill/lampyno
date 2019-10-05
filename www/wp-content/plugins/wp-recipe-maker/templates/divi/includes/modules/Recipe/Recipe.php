<?php

class WPRM_Divi_Module_Recipe extends ET_Builder_Module {

	public $slug       = 'wprm_recipe';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://bootstrapped.ventures/wp-recipe-maker',
		'author'     => 'Bootstrapped Ventures',
		'author_uri' => 'https://bootstrapped.ventures',
	);

	public function init() {
		$this->name = 'WPRM Recipe';
	}

	public function get_fields() {
		return array(
			'heading'     => array(
				'label'           => esc_html__( 'Heading', 'simp-simple-extension' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired heading here.', 'simp-simple-extension' ),
				'toggle_slug'     => 'main_content',
			),
			'content'     => array(
				'label'           => esc_html__( 'Content', 'simp-simple-extension' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear below the heading text.', 'simp-simple-extension' ),
				'toggle_slug'     => 'main_content',
			),
		);
	}

	public function get_advanced_fields_config() {
		return array(
			'background' => false,
			'padding' => false,
			'css_fields' => false,
			'css' => false,
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		return sprintf(
			'<h1 class="simp-simple-header-heading">%1$s</h1>
			<p>%2$s</p>',
			esc_html( $this->props['heading'] ),
			$this->props['content']
		);
	}
}

new WPRM_Divi_Module_Recipe;
