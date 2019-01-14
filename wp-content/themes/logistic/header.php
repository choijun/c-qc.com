<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>><!--<![endif]-->
<head>
<meta name="robots" content="index, nofollow"/>


<link rel="stylesheet" href="http://c-qc.com/wp-content/themes/logistic/css/form.css" />
	<title><?php wp_title(); ?></title>
    <?php if (!defined('WPSEO_VERSION')) { /*if YOAST plugin activated, let it do its work*/?>
	<meta name="description" content="<?php if(wp_title('')) { esc_attr(wp_title('')); echo ' | '; } esc_attr(bloginfo( 'description' )); ?>" />
    <?php } ?>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta charset="<?php esc_attr(bloginfo( 'charset' )); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="icon" href="<?php echo esc_url(ozy_get_option('favicon')); ?>" type="image/x-icon" />

    <link rel="apple-touch-icon" href="<?php echo esc_url(ozy_get_option('favicon_apple_small')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url(ozy_get_option('favicon_apple_medium')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url(ozy_get_option('favicon_apple_large')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url(ozy_get_option('favicon_apple_xlarge')); ?>">
    
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php esc_attr(bloginfo( 'name' )); ?>" href="<?php esc_attr(bloginfo( 'rss2_url' )); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php esc_attr(bloginfo( 'name' )); ?>" href="<?php esc_attr(bloginfo( 'atom_url' )); ?>" />

    <script type="text/javascript">var $OZY_WP_AJAX_URL = "<?php echo esc_url(admin_url('admin-ajax.php')) ?>", $OZY_WP_IS_HOME = <?php echo (is_home() || is_front_page() ? 'true' : 'false') ?>, $OZY_WP_HOME_URL = "<?php echo esc_url(home_url()) ?>";</script>
    <?php global $ozyHelper, $ozy_global_params, $ozy_data; ?>
	<?php wp_head(); /* this is used by many Wordpress features and for plugins to work proporly */ ?>
  <noindex><script async src="https://stats.lptracker.ru/code/new/58157"></script></noindex>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MWQWHL3');</script>
<!-- End Google Tag Manager -->

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MWQWHL3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

</head>

<body <?php body_class(); ?>>
	<?php 
	if($ozy_data->is_animsition_active) echo '<div class="animsition">';

    include_once('include/primary-menu.php');        
    include_once('include/google-maps_bg.php'); /* google maps background */ 
    ?>        
    <div class="none">
        <p><a href="#content"><?php _e('Skip to Content', 'logistic'); ?></a></p><?php /* used for accessibility, particularly for screen reader applications */ ?>
    </div><!--.none-->
    <?php
        $ozy_data->header_slider = ozy_check_header_slider();
        $ozy_data->footer_slider = ozy_check_footer_slider();
    ?>
    
    <div id="main" class="<?php echo $ozy_data->header_slider[0] !='' ? ' header-slider-active' : ''; echo $ozy_data->footer_slider[0] !='' ? ' footer-slider-active' : ''; ?>">
        <?php
        include_once('include/header.php');
        ?>
        <div class="container <?php echo esc_attr($content_css); ?>">
        
            