<?php
/**
 * Site General
 * ================
 */
$section  = 'site_general';
$priority = 3;

function frontpage_setup( $wp_customize ) {
	$wp_customize->get_control( 'show_on_front' )->section  = 'site_general';
	$wp_customize->get_control( 'show_on_front' )->priority = '3';
	$wp_customize->get_control( 'page_on_front' )->section  = 'site_general';
	$wp_customize->get_control( 'page_on_front' )->priority = '4';
	$wp_customize->get_control( 'page_on_front' )->label    = 'Choose a page';
	$wp_customize->get_control( 'show_on_front' )->label    = '';
}

add_action( 'customize_register', 'frontpage_setup' );

Kirki::add_field( 'infinity', array(
	'type'      => 'select',
	'setting'   => 'skin',
	'label'     => __( 'Skin', 'infinity' ),
	'section'   => $section,
	'choices'   => apply_filters( 'tm_customizer_skins', array() ),
	'priority'  => 1,
	'default'   => apply_filters( 'tm_customizer_default_skin', '' ),
	'transport' => 'postMessage'
) );

Kirki::add_field( 'infinity', array(
	'type'     => 'custom',
	'setting'  => 'site_general_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => 2,
	'default'  => '<div class="group_title">Front page</div>',
) );

Kirki::add_field( 'infinity', array(
	'type'     => 'custom',
	'setting'  => 'site_general_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">Other settings</div>',
) );

Kirki::add_field( 'infinity', array(
	'type'        => 'toggle',
	'setting'     => 'site_general_backtotop_enable',
	'label'       => __( 'Back to top', 'infinity' ),
	'description' => __( 'Enabling this option will display Back to top button', 'infinity' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

if ( function_exists( 'tm_bread_crumb' ) ) {
	Kirki::add_field( 'infinity', array(
		'type'        => 'toggle',
		'setting'     => 'site_general_breadcrumb_enable',
		'label'       => __( 'Breadcrumb', 'infinity' ),
		'description' => __( 'Enabling this option will display breadcrumb on every page', 'infinity' ),
		'section'     => $section,
		'priority'    => $priority ++,
		'default'     => 1,
	) );
}

Kirki::add_field( 'infinity', array(
	'type'        => 'toggle',
	'setting'     => 'site_general_boxed',
	'label'       => __( 'Boxed mode', 'infinity' ),
	'description' => __( 'Turn on this option if you want to enable box mode for content', 'infinity' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 0,
) );

