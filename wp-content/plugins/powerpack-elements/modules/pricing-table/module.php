<?php
namespace PowerpackElements\Modules\PricingTable;

use PowerpackElements\Base\Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Module_Base {

	public function get_name() {
		return 'pp-pricing-table';
	}

	public function get_widgets() {
		return [
			'Pricing_Table',
		];
	}
}
