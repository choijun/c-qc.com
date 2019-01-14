<?php
/**
 * Plugin Name: PowerPack Elements
 * Plugin URI: https://powerpackelements.com
 * Description: Пользовательские аддоны для компоновщика страниц элемента.
 * Version: 1.3.8.1
 * Author: Team IdeaBox - PowerPack Elements
 * Author URI: http://powerpackelements.com
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: power-pack
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'POWERPACK_ELEMENTS_VER', '1.3.8.1' );
define( 'POWERPACK_ELEMENTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'POWERPACK_ELEMENTS_BASE', plugin_basename( __FILE__ ) );
define( 'POWERPACK_ELEMENTS_URL', plugins_url( '/', __FILE__ ) );
define( 'POWERPACK_ELEMENTS_ELEMENTOR_VERSION_REQUIRED', '1.7' );
define( 'POWERPACK_ELEMENTS_PHP_VERSION_REQUIRED', '5.4' );

require_once POWERPACK_ELEMENTS_PATH . 'includes/helper-functions.php';
require_once POWERPACK_ELEMENTS_PATH . 'plugin.php';
require_once POWERPACK_ELEMENTS_PATH . 'classes/class-pp-admin-settings.php';
require_once POWERPACK_ELEMENTS_PATH . 'classes/class-pp-ajax-handler.php';
require_once POWERPACK_ELEMENTS_PATH . 'classes/class-pp-wpml.php';
require_once POWERPACK_ELEMENTS_PATH . 'includes/updater/update-config.php';

/**
 * Check if Elementor is installed
 *
 * @since 1.0
 *
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {
	function _is_elementor_installed() {
		$file_path = 'elementor/elementor.php';
		$installed_plugins = get_plugins();
		return isset( $installed_plugins[ $file_path ] );
	}
}

/**
 * Shows notice to user if Elementor plugin
 * is not installed or activated or both
 *
 * @since 1.0
 *
 */
function pa_fail_load() {
    $plugin = 'elementor/elementor.php';

	if ( _is_elementor_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
        $message = __( 'PowerPack требует, чтобы плагин Elementor был активным. Пожалуйста, активируйте Elementor, чтобы продолжить.', 'power-pack' );
		$button_text = __( 'Активировать Elementor', 'power-pack' );

	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
        $message = sprintf( __( 'PowerPack требует %1$s"Elementor"%2$s  для установки и активации. Пожалуйста, установите Elementor для продолжения. ', 'power-pack' ), '<strong>', '</strong>' );
		$button_text = __( 'Install Elementor', 'power-pack' );
	}

	$button = '<p><a href="' . $activation_url . '" class="button-primary">' . $button_text . '</a></p>';
    
    printf( '<div class="error"><p>%1$s</p>%2$s</div>', esc_html( $message ), $button );
}

/**
 * Shows notice to user if
 * Elementor version if outdated
 *
 * @since 1.0
 *
 */
function pa_fail_load_out_of_date() {
    if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}
    
	$message = __( 'PowerPack требует версию Elementor как минимум ' . POWERPACK_ELEMENTS_ELEMENTOR_VERSION_REQUIRED . '. Обновите элемент Elementor, чтобы продолжить.', 'power-pack' );

	printf( '<div class="error"><p>%1$s</p></div>', esc_html( $message ) );
}

/**
 * Shows notice to user if minimum PHP
 * version requirement is not met
 *
 * @since 1.0
 *
 */
function pa_fail_php() {
	$message = __( 'PowerPack требует версию PHP ' . POWERPACK_ELEMENTS_PHP_VERSION_REQUIRED .'+ для правильной работы. Плагины деактивированы на данный момент.', 'power-pack' );

	printf( '<div class="error"><p>%1$s</p></div>', esc_html( $message ) );

	if ( isset( $_GET['activate'] ) ) 
		unset( $_GET['activate'] );
}

/**
 * Deactivates the plugin
 *
 * @since 1.0
 */
function pa_deactivate() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

/**
 * Load theme textdomain
 *
 * @since 1.0
 *
 */
function pp_load_plugin_textdomain() {
	load_plugin_textdomain( 'power-pack', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 * Assigns category to PowerPack
 *
 * @since 1.0
 *
 */
function pp_category() {
	\Elementor\Plugin::instance()->elements_manager->add_category(
        'power-pack',
        array(
            'title' => \PowerpackElements\Classes\PP_Admin_Settings::get_admin_label(),
            'icon'  => 'font',
        ),
	    1 );
}

add_action( 'plugins_loaded', 'pp_init' );

function pp_init() {
    if ( class_exists( 'Caldera_Forms' ) ) {
        add_filter( 'caldera_forms_force_enqueue_styles_early', '__return_true' );
    }

    // Notice if the Elementor is not active
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'pa_fail_load' );
		return;
	}

	// Check for required Elementor version
	if ( ! version_compare( ELEMENTOR_VERSION, POWERPACK_ELEMENTS_ELEMENTOR_VERSION_REQUIRED, '>=' ) ) {
		add_action( 'admin_notices', 'pa_fail_load_out_of_date' );
		add_action( 'admin_init', 'pa_deactivate' );
		return;
	}
    
    // Check for required PHP version
	if ( ! version_compare( PHP_VERSION, POWERPACK_ELEMENTS_PHP_VERSION_REQUIRED, '>=' ) ) {
		add_action( 'admin_notices', 'pa_fail_php' );
		add_action( 'admin_init', 'pa_deactivate' );
		return;
	}
    
    add_action( 'init', 'pp_load_plugin_textdomain' );

	add_action( 'elementor/init', 'pp_category' );
}

/**
 * Enable white labeling setting form after re-activating the plugin
 *
 * @since 1.0.1
 * @return void
 */
function pp_plugin_activation()
{
	$settings = get_site_option( 'pp_elementor_settings' );
	
	if ( is_array( $settings ) ) {
		$settings['hide_wl_settings'] = 'off';
		$settings['hide_plugin'] = 'off';
	}

	update_site_option( 'pp_elementor_settings', $settings );
}
register_activation_hook( __FILE__, 'pp_plugin_activation' );