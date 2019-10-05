# cmb2-yesno-field
This is the cmb2 yes/no field that can be used to yes/no or enable/disable field.

This is verstion 1.0.
THis can be used as the same as the CMB2 metabox.



This can be used as below

Initilize the cmb2 to the required Post type..

	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
	) );


and add the field to the instance of the cmb2.

	$cmb_demo->add_field(array(
	'name'    => 'Show on Home Page',
	'id'      => $prefix . 'show_on_home',
	'desc'    => 'DO you want to show on the homepage or not?',
	'type'    => 'own_yesno',
	));
