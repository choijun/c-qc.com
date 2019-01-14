<?php
/**
 * Plugin Name: Element Pack
 * Plugin URI: http://bdthemes.com/
 * Description: Element Pack - это упакованный элементный элемент. Этот плагин предоставляет вам дополнительные функции виджетов для плагина компоновщика страницы elementor.
 * Version: 2.6.5
 * Author: BdThemes
 * Author URI: https://bdthemes.com/
 * Text Domain: bdthemes-element-pack
 * Domain Path: /languages
 * License: GPL3
 * Elementor requires at least: 2.1.0
 * Elementor tested up to: 2.3.4
 */

// Some pre define value for easy use
define( 'BDTEP_VER', '2.6.5' );
define( 'BDTEP__FILE__', __FILE__ );
define( 'BDTEP_PNAME', basename( dirname(BDTEP__FILE__)) );
define( 'BDTEP_PBNAME', plugin_basename(BDTEP__FILE__) );
define( 'BDTEP_PATH', plugin_dir_path( BDTEP__FILE__ ) );
define( 'BDTEP_MODULES_PATH', BDTEP_PATH . 'modules/' );
define( 'BDTEP_URL', plugins_url( '/', BDTEP__FILE__ ) );
define( 'BDTEP_ASSETS_URL', BDTEP_URL . 'assets/' );
define( 'BDTEP_MODULES_URL', BDTEP_URL . 'modules/' );

/**
 * You can easily add white label branding for for extended license or multi site license. 
 * Don't try for regular license otherwise your license will be invalid.
 * Just define those var in your theme function
 * @return White Label
 */
function element_pack_defined_string() {
	if (!defined('BDTEP')) { define( 'BDTEP', '' ); } //Add prefix for all widgets
	if (!defined('BDTEP_CP')) { define( 'BDTEP_CP', '<span class="bdt-widget-badge"></span>' ); } // if you have any custom style
	if (!defined('BDTEP_SLUG')) { define( 'BDTEP_SLUG', 'element-pack' ); } // set your own alias 
	if (!defined('BDTEP_TITLE')) { define( 'BDTEP_TITLE', 'Element Pack' ); } // Set your own name for plugin
}
add_action( 'after_setup_theme', 'element_pack_defined_string' );


// Helper function here
include(dirname(__FILE__).'/includes/helper.php');
include(dirname(__FILE__).'/includes/utils.php');

/**
 * Plugin load here correctly
 * Also loaded the language file from here
 */
function bdthemes_element_pack_load_plugin() {
    load_plugin_textdomain( 'bdthemes-element-pack', false, basename( dirname( __FILE__ ) ) . '/languages' );

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'bdthemes_element_pack_fail_load' );
		return;
	}

	// Admin settings controller
    require( BDTEP_PATH . 'includes/class.settings-api.php' );
    // element pack admin settings here
    require( BDTEP_PATH . 'includes/admin-settings.php' );
	// Element pack widget and assets loader
    require( BDTEP_PATH . 'loader.php' );
}
add_action( 'plugins_loaded', 'bdthemes_element_pack_load_plugin' );


/**
 * Check Elementor installed and activated correctly
 */
function bdthemes_element_pack_fail_load() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }
		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
		$admin_message = '<p>' . esc_html__( 'Обана! Element Pack не работает, потому что вам нужно сначала активировать плагин Elementor.', 'bdthemes-element-pack' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Активировать Elementor сейчас', 'bdthemes-element-pack' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) { return; }
		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		$admin_message = '<p>' . esc_html__( 'Обана! Element Pack не работает, потому что вам нужно установить плагин Elementor', 'bdthemes-element-pack' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Установить Elementor сейчас', 'bdthemes-element-pack' ) ) . '</p>';
	}

	echo '<div class="error">' . $admin_message . '</div>';
}

/**
 * Check the elementor installed or not
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {

    function _is_elementor_installed() {
        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();

        return isset( $installed_plugins[ $file_path ] );
    }
}
