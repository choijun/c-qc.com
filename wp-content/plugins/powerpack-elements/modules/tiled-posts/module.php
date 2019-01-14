<?php
namespace PowerpackElements\Modules\TiledPosts;

use PowerpackElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'pp-tiled-posts';
	}

	public function get_widgets() {
		return [
			'Tiled_Posts',
		];
	}
}
