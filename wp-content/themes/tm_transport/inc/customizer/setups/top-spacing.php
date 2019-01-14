<?php
/**
 * Top Area Spacing
 * ============
 */
$section  = 'top_spacing';
$priority = 1;

Kirki::add_field( 'infinity', array(
	'type'      => 'text',
	'setting'   => 'top_general_padding',
	'label'     => __( 'Padding', 'infinity' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => '0px 0px 0px 0px',
	'transport' => 'postMessage',
	'output'    => array(
		'element'  => '.site-top',
		'property' => 'padding',
	),
) );

Kirki::add_field( 'infinity', array(
	'type'      => 'text',
	'setting'   => 'top_general_margin',
	'label'     => __( 'Margin', 'infinity' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => '0px 0px 0px 0px',
	'transport' => 'postMessage',
	'output'    => array(
		'element'  => '.site-top',
		'property' => 'margin',
	),
) );