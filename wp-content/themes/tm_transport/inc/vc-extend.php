<?php
/**
 * Initial setup
 * =============
 */
$new_vc_dir = get_template_directory() . '/inc/vc-template';
if ( function_exists( "vc_set_shortcodes_templates_dir" ) ) {
	vc_set_shortcodes_templates_dir( $new_vc_dir );
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Thememove_Recentposts extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Thememove_Testi extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Thememove_Button extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Thememove_Blog extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Thememove_Gmaps extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Thememove_Project_Details extends WPBakeryShortCode {
	}
}
locate_template( 'inc/vc-maps/blog.php', true, true );
locate_template( 'inc/vc-maps/button.php', true, true );
locate_template( 'inc/vc-maps/google-map.php', true, true );
locate_template( 'inc/vc-maps/recent-post.php', true, true );
locate_template( 'inc/vc-maps/testimonial.php', true, true );

// Disable updater
add_action( 'vc_before_init', 'disable_updater' );
function disable_updater() {
	vc_manager()->disableUpdater();
}
