<?php
vc_map( array(
	'name'     => __( 'TM Button', 'infinity' ),
	'base'     => 'thememove_button',
	'category' => __( 'by TM Transport', 'infinity' ),
	'params'   => array(
		array(
			'type'        => 'textfield',
			'heading'     => "Text",
			'admin_label' => true,
			'param_name'  => 'text',
		),
		array(
			'type'        => 'textfield',
			'heading'     => "Url",
			'admin_label' => true,
			'param_name'  => 'url',
			'description' => __( 'Entry your url here', 'infinity' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => "Icon",
			'admin_label' => true,
			'param_name'  => 'icon',
			'description' => __( 'Example: fa-arrow-right', 'infinity' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => "Class",
			'admin_label' => true,
			'param_name'  => 'el_class',
		),
	)
) );