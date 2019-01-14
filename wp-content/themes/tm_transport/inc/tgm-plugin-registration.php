<?php
if ( ! function_exists( 'infinity_register_theme_plugins' ) ) :
	function infinity_register_theme_plugins() {

		$plugins = array(
			array(
				'name'     => 'ThemeMove Core',
				'slug'     => 'thememove-core',
				'source'   => 'https://drive.google.com/uc?export=download&id=0By5Ytx4iv5jwaEtZMDJuQndWN0k',
				'version'  => '1.3.5.1',
				'required' => true,
			),
			array(
				'name'     => 'WP Bakery Page Builder',
				'slug'     => 'js_composer',
				'source'   => 'https://bitbucket.org/digitalcreative/thememove-plugins/raw/300db40dbb10f1c10fc9e3534fd94079fcf04b11/js_composer.zip',
				'version'  => '5.5.2',
				'required' => false
			),
			array(
				'name'     => 'Essential Grid',
				'slug'     => 'essential-grid',
				'source'   => 'https://bitbucket.org/digitalcreative/thememove-plugins/raw/4cd3ee0b7dd5d5b5cbfe4bb5be6107e00608b8b4/essential-grid.zip',
				'version'  => '2.2.5',
				'required' => false
			),
			array(
				'name'     => 'Revolution Slider',
				'slug'     => 'revslider',
				'source'   => 'https://bitbucket.org/digitalcreative/thememove-plugins/raw/300db40dbb10f1c10fc9e3534fd94079fcf04b11/revslider.zip',
				'version'  => '5.4.8',
				'required' => false
			),
			array(
				'name'     => 'Testimonials by WooThemes',
				'slug'     => 'testimonials-by-woothemes',
				'required' => false,
			),
			array(
				'name'     => 'WooCommerce',
				'slug'     => 'woocommerce',
				'required' => false,
			),
			array(
				'name'     => 'Widget Logic',
				'slug'     => 'widget-logic',
				'required' => false,
			),
			array(
				'name'     => 'Contact Form 7',
				'slug'     => 'contact-form-7',
				'required' => false,
			),
		);

		$config = array(
			'id'           => 'tgmpa',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'dismissable'  => false,
			'dismiss_msg'  => '',
			'is_automatic' => true,
			'message'      => '',
		);

		tgmpa( $plugins, $config );

	}

	add_action( 'tgmpa_register', 'infinity_register_theme_plugins' );
endif;
