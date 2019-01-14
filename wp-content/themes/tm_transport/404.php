<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Infinity
 */

get_header(); ?>

<div class="big-title" style="background-image: url('<?php echo esc_url( $infinity_heading_image ); ?>')">
	<div class="container">
		<h1 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'infinity' ); ?></h1>
		<?php if ( function_exists( 'tm_bread_crumb' ) && Kirki::get_option( 'infinity', 'site_general_breadcrumb_enable' ) == 1 ) { ?>
			<div class="breadcrumb">
				<div class="container">
					<?php echo tm_bread_crumb( array( 'home_label' => __( 'Home', 'infinity' ) ) ); ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<div class="content container center">
	<i class="fa fa-frown-o"></i>

	<div class="vc_custom_heading style1"><h2>LOOKS LIKE SOMETHING WENT WRONG!</h2></div>
	<p>The page you were looking for is not here. Maybe you want to perform a search?</p>

	<div class="row center">
		<div class="col-md-6">
			<div class="sidebar">
				<div class="widget_search">
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
