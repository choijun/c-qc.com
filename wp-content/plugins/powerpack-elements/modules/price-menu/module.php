<?php
namespace PowerpackElements\Modules\PriceMenu;

use PowerpackElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'pp-price-menu';
	}

	public function get_widgets() {
		return [
			'Price_Menu',
		];
	}
}
