<?php
/**
* Constants
*/
define( 'OZY_BASE_DIR', get_template_directory() . '/' );
define( 'OZY_BASE_URL', get_template_directory_uri() . '/' );
define( 'OZY_CSS_DIRECTORY_URL', get_stylesheet_directory_uri() . '/');
define( 'OZY_HOME_URL', home_url() . '/' );
define( 'OZY_THEME_VERSION', '4.3' );
define( 'OZY_THEMENAME', 'LOGISTIC' ); //used in TGM Plugin Activation
define( 'OZY_MAX_INFO_BAR_ENTRY', 5 );
if(function_exists("icl_get_languages") && defined("ICL_LANGUAGE_CODE") && defined('ICL_LANGUAGE_NAME') && function_exists('icl_object_id')){global $sitepress;define( 'OZY_WPLANG', $sitepress->get_default_language());}else{define( 'OZY_WPLANG', substr(get_bloginfo('language'), 0, 2));}
define( 'SK_SUBSCRIPTION_ID',1696 );
define( 'SK_ENVATO_PARTNER', 'IdiBEpP9oju01Fd+NhFzBLZBIamiWGdVCS4v5poYSOo=' );
define( 'SK_ENVATO_SECRET', 'RqjBt/YyaTOjDq+lKLWhL10sFCMCJciT9SPUKLBBmso=' );

/**
* Update Notifier
*/
require('functions/classes/update-notifier.php');
define( 'OZY_NOTIFIER_THEME_NAME', OZY_THEMENAME );
define( 'OZY_NOTIFIER_THEME_FOLDER_NAME', 'logistic' );
define( 'OZY_NOTIFIER_XML_FILE', 'http://s3-eu-west-1.amazonaws.com/themeversion/logistic.xml' );
define( 'OZY_NOTIFIER_CACHE_INTERVAL', 43200);

/**
* Globals
*/
$ozy_data = new stdClass();

locate_template('functions/classes/helper.php', true, true);

global $ozyHelper, 
	$ozy_temporary_post_title, 
	$ozy_temporary_post_format, 
	$ozy_global_params;
	
$ozyHelper = new Ozy_myHelper;

/**
* WPML Plugin Check
*/	
$ozy_data->wpml_current_language_	= '';
if(defined("ICL_LANGUAGE_CODE") && ICL_LANGUAGE_CODE != OZY_WPLANG) {
	$ozy_data->wpml_current_language_ = '_' . ICL_LANGUAGE_CODE;
}
	
/**
* Sets up theme defaults and registers support for various WordPress features.
*/   

add_action('after_setup_theme', 'ozy_theme_setup');	
function ozy_theme_setup() {
	// Load Languages
	load_theme_textdomain('logistic', get_template_directory() . '/lang/');

	// Adds Post Format support
	// learn more: http://codex.wordpress.org/Post_Formats
	add_theme_support( 'post-formats', array( 
		'aside', 
		'gallery',
		'link',
		'image',
		'quote',
		'status',
		'video',
		'audio',
		'chat' ) 
	);

	// Declare Automatic Feed Links support
	add_theme_support( 'automatic-feed-links' );
	
	// Declare WooCommerce support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );	
		
	// Post thumbnail support
	add_theme_support( 'post-thumbnails' );
	
	// Custom menu support
	add_theme_support( 'menus' );
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
			  'header-menu' => 'Primary Menu',
			  'logged-in-menu' => 'Logged In Primary Menu'
			)
		);
	}

	// Add custom thumbnail sizes
	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'boxyboxy', 480, 480, true );
		add_image_size( 'showbiz', 720, 720, true ); /*466x466 older version*/
		add_image_size( 'blog', 1144, 9999, false );
	}	
	
	// Enable shortcodes in the widgets
	add_filter('widget_text', 'shortcode_unautop');
	add_filter('widget_text', 'do_shortcode');	
	
	// Removes detailed login error information for security	
	add_filter('login_errors',create_function('$a', "return null;"));	
	
	// Default media sizes
	//global $content_width;
	if (!isset($content_width)) $content_width = 1140;	
}

/**
* TGM Plugin Activator
*/
require_once 'functions/plugins.php';

/**
* Include Vafpress Framework
*/
require_once 'framework/bootstrap.php';
	
/**
* Include Custom Data Sources
*/
require_once 'admin/data_sources.php';

/**
* Mobile Check Class
*/
require_once 'functions/classes/mobile-check.php';

/**
* Theme options initializing here
*/
$ozy_tmpl_opt = OZY_BASE_DIR . 'admin/option/option.php';

/*
* Chat Formatter
*/
//if(is_single() || is_page()) {
	include_once('functions/chat.formatter.php');
//}

/*
* Widgets
*/
require_once 'functions/widgets.php';

/**
* Main functions / actions / hooks
*/
include_once('functions/functions.php');

/**
* Include Dynamic Sidebars
*/
require_once 'functions/sidebars.php';

/**
* Create instance of Theme Options
*/
$theme_options = new VP_Option(array(
	'is_dev_mode' 			=> false, // dev mode, default to false
	'option_key' 			=> 'vpt_ozy_logistic_option', // options key in db, required
	'page_slug' 			=> 'vpt_option', // options page slug, required
	'template' 				=> $ozy_tmpl_opt, // template file path or array, required
	'menu_page' 			=> 'themes.php', // parent menu slug or supply `array` (can contains 'icon_url' & 'position') for top level menu
	'use_auto_group_naming' => true, // default to true
	'use_exim_menu' 		=> true, // default to true, shows export import menu
	'minimum_role' 			=> 'edit_theme_options', // default to 'edit_theme_options'
	'layout' 				=> 'fixed', // fluid or fixed, default to fixed
	'page_title' 			=> __( 'Theme Options', 'logistic' ), // page title
	'menu_label' 			=> __( 'Theme Options', 'logistic' ), // menu label
));

/**
* Load option based css
*/
locate_template('functions/option-based-css.php', true, true);

/**
* Custom Menu Items
*/
if(defined('OZY_LOGISTIC_ESSENTIALS_ACTIVATED')) {
	require_once 'functions/menu-item-custom-fields/menu-item-custom-fields.php';
	require_once 'functions/menu-item-custom-fields/menu-item-custom-fields-megamenu.php';
}

/**
* Visual Composer Add-On visual shortcodes
*/
global $ozy_data;
$ozy_data->vc_active = false;

//if(function_exists('wpb_js_composer_check_version_schedule_deactivation')) { wpb_js_composer_check_version_schedule_deactivation(); }	

function ozy_init_vc_shortcodes() {
	if ( ! function_exists( 'is_plugin_active' ) ) require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	if(is_plugin_active("js_composer/js_composer.php") && 
		function_exists('vc_map') && 
		function_exists('vc_set_as_theme')) {

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		/* Make visual composer part of the theme */
		vc_set_as_theme();
		
		//Remove frontend editor
		if(function_exists('vc_disable_frontend')){vc_disable_frontend();}
	
		global $ozy_data;
		include_once('functions/vc_extend.php');
		//include_once('functions/shortcodes.php');
		$ozy_data->vc_active = true;
	}
}
add_action( 'init', 'ozy_init_vc_shortcodes', 99 );

/**
* Customize Tag Cloud widget
*/
function ozy_tag_cloud_fix($tag_string){
   return preg_replace("/style='font-size:.+pt;'/", '', $tag_string);
}
add_filter('wp_generate_tag_cloud', 'ozy_tag_cloud_fix',10,3);

/**
* Curl operations
*/
function ozy_fetchCurlData($url) {
	if(function_exists('curl_version')) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 	
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}else{
		return '-10';
	}
}

function ozy_get_default_language_code() {
	$lang_code = get_bloginfo("language");
	if(strpos($lang_code, '-')) {
		$lang_code = explode('-', $lang_code);	
		return $lang_code[0];
	}
	return $lang_code;
}

function ozy_is_wpml_active() {
	if(function_exists("icl_get_languages") && defined("ICL_LANGUAGE_CODE") && defined("ICL_LANGUAGE_NAME")) {
		return true;
	}
	return false;
}

function ozy_is_date_between($dt_start, $dt_check, $dt_end) {
    if(strtotime($dt_check) >= strtotime($dt_start) && strtotime($dt_check) <= strtotime($dt_end)) {
        return true;
	}
    return false;
}

function ozy_htmlentitiesOutsideHTMLTags ($htmlText) {
    $matches = Array();
    $sep = '###HTMLTAG###';
    preg_match_all("@<[^>]*>@", $htmlText, $matches);   
    $tmp = preg_replace("@(<[^>]*>)@", $sep, $htmlText);
    $tmp = explode($sep, $tmp);

    for ($i=0; $i<count($tmp); $i++)
        $tmp[$i] = htmlentities($tmp[$i]);

    $tmp = join($sep, $tmp);

    for ($i=0; $i<count($matches[0]); $i++)
        $tmp = preg_replace("@$sep@", $matches[0][$i], $tmp, 1);

    return $tmp;
}
?>