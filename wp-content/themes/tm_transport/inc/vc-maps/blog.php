<?php
vc_map( array(
	'name'     => __( 'TM Blog', 'infinity' ),
	'base'     => 'thememove_blog',
	'category' => __( 'by TM Transport', 'infinity' ),
	'params'   => array(
		array(
			"type"       => "dropdown",
			"heading"    => "Show Share Buttons",
			"param_name" => "enable_share",
			"value"      => array(
				"No"  => 'false',
				"Yes" => 'true',
			),
		),
	)
) );