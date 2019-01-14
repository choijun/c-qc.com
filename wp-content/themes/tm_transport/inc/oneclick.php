<?php

add_filter( 'thememove_import_demos', 'tm_transport_import_demos' );

function tm_transport_import_demos() {
	return array(
		'thememove01' => array(
			'screenshot' => THEME_ROOT . '/screenshot.png',
			'name'       => PARENT_THEME_NAME
		)
	);
}

add_filter( 'thememove_import_style', 'tm_transport_import_style' );

function tm_transport_import_style() {
	return array(
		'title_color'  => '#222222',
		'link_color'   => '#FBD232',
		'notice_color' => '#FBD232',
		'logo'         => THEME_ROOT . '/images/logo2.png',
	);
}

add_filter('thememove_import_package_url', 'tm_transport_import_package_url');

function tm_transport_import_package_url() {
	return 'http://api.insightstud.io/update/transport/import/tm_transport-thememove01.zip';
}

//add_filter( 'thememove_import_generate_thumb', 'tm_transport_import_generate_thumb' );
//
//function tm_transport_import_generate_thumb() {
//	return true;
//}
