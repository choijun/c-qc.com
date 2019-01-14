<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Infinity
 */
$infinity_back_to_top = Kirki::get_option( 'infinity', 'site_general_backtotop_enable' );
?>
</div><!-- #content -->
<?php if ( is_active_sidebar( 'footer' ) ) { ?>
	<footer <?php footer_class(); ?>>
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<?php dynamic_sidebar( 'footer' ); ?>
					<div class="social">
						<?php wp_nav_menu( array(
							'theme_location'  => 'social',
							'menu_id'         => 'social-menu',
							'container_class' => 'social-menu',
							'fallback_cb'     => false
						) ); ?>
					</div>
				</div>
				<div class="col-md-4">
					<?php dynamic_sidebar( 'footer2' ); ?>
				</div>
				<div class="col-md-4">
					<?php dynamic_sidebar( 'footer3' ); ?>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
<?php } ?>
<?php if ( Kirki::get_option( 'infinity', 'copyright_layout_enable' ) == 1 ) { ?>
	<div class="copyright">
		<div class="container">
			<div class="row middle">
				<div class="col-md-4 left">
					<?php echo html_entity_decode( Kirki::get_option( 'infinity', 'copyright_layout_left_text' ) ); ?>
				</div>
				<div class="col-md-8 end-md end-lg">
					<div class="right">
						<?php echo html_entity_decode( Kirki::get_option( 'infinity', 'copyright_layout_right_text' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
</div><!-- #page -->
<?php if ( $infinity_back_to_top ) { ?>
	<a class="scrollup"><i class="fa fa-angle-up"></i></a>
<?php } ?>
<nav id="menu">
	<?php Transport::top_menu() ?>
</nav>
<script>
	jQuery(document).ready(function ($) {
		$(function() {
			$('nav#menu').mmenu();
		});
	});
</script>
<?php wp_footer(); ?>
<!-- BS:SNIPPET--><script id="__bs_script__">//<![CDATA[
    document.write("<script async src='http://HOST:3002/browser-sync/browser-sync-client.js?v=2.21.0'><\/script>".replace("HOST", location.hostname));
//]]></script>
<!-- BS:SNIPPET:END-->
</body>
</html>
