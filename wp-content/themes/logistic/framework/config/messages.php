<?php

return array(

	////////////////////////////////////////
	// Localized JS Message Configuration //
	////////////////////////////////////////

	/**
	 * Validation Messages
	 */
	'validation' => array(
		'alphabet'     => __('Value needs to be Alphabet', 'logistic'),
		'alphanumeric' => __('Value needs to be Alphanumeric', 'logistic'),
		'numeric'      => __('Value needs to be Numeric', 'logistic'),
		'email'        => __('Value needs to be Valid Email', 'logistic'),
		'url'          => __('Value needs to be Valid URL', 'logistic'),
		'maxlength'    => __('Length needs to be less than {0} characters', 'logistic'),
		'minlength'    => __('Length needs to be more than {0} characters', 'logistic'),
		'maxselected'  => __('Select no more than {0} items', 'logistic'),
		'minselected'  => __('Select at least {0} items', 'logistic'),
		'required'     => __('This is required', 'logistic'),
	),

	/**
	 * Import / Export Messages
	 */
	'util' => array(
		'import_success'    => __('Import succeed, option page will be refreshed..', 'logistic'),
		'import_failed'     => __('Import failed', 'logistic'),
		'export_success'    => __('Export succeed, copy the JSON formatted options', 'logistic'),
		'export_failed'     => __('Export failed', 'logistic'),
		'restore_success'   => __('Restoration succeed, option page will be refreshed..', 'logistic'),
		'restore_nochanges' => __('Options identical to default', 'logistic'),
		'restore_failed'    => __('Restoration failed', 'logistic'),
	),

	/**
	 * Control Fields String
	 */
	'control' => array(
		// select2 select box
		'select2_placeholder' => __('Select option(s)', 'logistic'),
		// fontawesome chooser
		'fac_placeholder'     => __('Select an Icon', 'logistic'),
	),

);

/**
 * EOF
 */