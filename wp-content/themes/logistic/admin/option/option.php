<?php
$footer_copyright_array =		array(
									array(
										'type' => 'textbox',
										'name' => 'ozy_logistic_section_footer_copyright_text',
										'label' => esc_attr__('Footer Text', 'logistic') . ' ('. OZY_WPLANG . ')',
										'default' => esc_attr__('&copy;', 'logistic') . date('Y') . esc_attr(' Logistic - All Rights Reserved', 'logistic')
									)
								);								

if(ozy_is_wpml_active()){
	$languages = icl_get_languages('skip_missing=0&orderby=code');
	if(!empty($languages)){
		foreach($languages as $l){
			if(OZY_WPLANG != $l['language_code']) {
				array_push($footer_copyright_array, array(
													'type' => 'textbox',
													'name' => 'ozy_logistic_section_footer_copyright_text' . $l['language_code'],
													'label' => __('Footer Text', 'logistic') . ' (' . strtoupper($l['native_name']) .')'
												));
			}
		}
	}
}

$top_info_bar_field_arr = 
					array(
						array(
							'type' => 'section',
							'title' => __('Top Info Bar', 'logistic'),
							'name' => 'ozy_logistic_section_top_info_bar_layout',
							'fields' => array(
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_top_info_bar_is_active',
									'label' => esc_attr__('Is Active?', 'logistic'),
									'default' => 0
								)
							),
						)						
					);
					
for($i = 1; $i <= (int)OZY_MAX_INFO_BAR_ENTRY; $i++) { //if you want more or less entry, see functions.php head section
	array_push($top_info_bar_field_arr, 
		array(
			'type' => 'section',
			'title' => __('Info Line #'.$i.'', 'logistic'),
			'name' => 'ozy_logistic_section_top_info_bar_layout'.$i,
			'dependency' => array(
				'field' => 'ozy_logistic_top_info_bar_is_active',
				'function' => 'vp_dep_boolean',
			),
			'fields' => array(				
				array(
					'type' => 'textbox',
					'name' => 'ozy_logistic_top_info_bar_info_caption'.$i,
					'label' => esc_attr__('Caption', 'logistic'),
					'default' => esc_attr__('Italia Office', 'logistic')
				),								
				array(
					'type' => 'fontawesome',
					'name' => 'ozy_logistic_top_info_bar_info_icon'. $i .'_1',
					'label' => esc_attr__('Icon', 'logistic'),
					'default' => 'fa-map-marker'
				),
				array(
					'type' => 'textbox',
					'name' => 'ozy_logistic_top_info_bar_info_title'. $i .'_1',
					'label' => esc_attr__('Title', 'logistic'),
					'default' => esc_attr__('via G. Cesare 87/A 47838 Riccione (RN) Italia', 'logistic')
				),
				array(
					'type' => 'fontawesome',
					'name' => 'ozy_logistic_top_info_bar_info_icon'. $i .'_2',
					'label' => esc_attr__('Icon', 'logistic'),
					'default' => 'fa-clock-o'
				),
				array(
					'type' => 'textbox',
					'name' => 'ozy_logistic_top_info_bar_info_title'. $i .'_2',
					'label' => esc_attr__('Title', 'logistic'),
					'default' => esc_attr__('Mon - Sat 8.00 - 18.00. Sunday CLOSED', 'logistic')
				),
				array(
					'type' => 'fontawesome',
					'name' => 'ozy_logistic_top_info_bar_info_icon'. $i .'_3',
					'label' => esc_attr__('Icon', 'logistic'),
					'default' => 'fa-mobile'
				),
				array(
					'type' => 'textbox',
					'name' => 'ozy_logistic_top_info_bar_info_title'. $i .'_3',
					'label' => esc_attr__('Title', 'logistic'),
					'default' => esc_attr__('+39 0541 647087', 'logistic')
				),								
			),
		)
	);
}

//return 
$ozy_logistic_option_arr = array(
	'title' => __('LOGISTIC Option Panel', 'logistic'),
	'logo' => OZY_BASE_URL . 'admin/images/logo.png',
	'menus' => array(
		array(
			'title' => __('General Options', 'logistic'),
			'name' => 'ozy_logistic_general_options',
			'icon' => 'font-awesome:fa-gear',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => __('General', 'logistic'),
					'fields' => array(
						array(
							'type' => 'toggle',
							'name' => 'ozy_logistic_back_to_top_button',
							'label' => __('Back To Top Button', 'logistic'),
							'description' => __('Enable / Disable Back To Top Button globally.', 'logistic'),
							'default' => '1',
						),						
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_favicon',
							'label' => __('Favicon', 'logistic'),
							'description' => __('Upload a 16px x 16px .png or .gif image, will be set as your favicon.', 'logistic'),
							'default' => get_stylesheet_directory_uri() . '/favico.png',
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_favicon_apple_small',
							'label' => __('Apple Touch Icon (small)', 'logistic'),
							'description' => __('Upload a 57px x 57px .png image, will be set as your small Apple Touch Icon.', 'logistic'),
							'default' => get_stylesheet_directory_uri() . '/images/favico_57.png',
						),array(
							'type' => 'upload',
							'name' => 'ozy_logistic_favicon_apple_medium',
							'label' => __('Apple Touch Icon (medium)', 'logistic'),
							'description' => __('Upload a 76px x 76px .png image, will be set as your large Apple Touch Icon (iPad).', 'logistic'),
							'default' => get_stylesheet_directory_uri() . '/images/favico_76.png',
						),array(
							'type' => 'upload',
							'name' => 'ozy_logistic_favicon_apple_large',
							'label' => __('Apple Touch Icon (large)', 'logistic'),
							'description' => __('Upload a 120px x 120px .png image, will be set as your large Apple Touch Icon (iPhone Retina).', 'logistic'),
							'default' => get_stylesheet_directory_uri() . '/images/favico_120.png',
						),array(
							'type' => 'upload',
							'name' => 'ozy_logistic_favicon_apple_xlarge',
							'label' => __('Apple Touch Icon (large)', 'logistic'),
							'description' => __('Upload a 152px x 152px .png image, will be set as your large Apple Touch Icon (iPad Retina).', 'logistic'),
							'default' => get_stylesheet_directory_uri() . '/images/favico_152.png',
						),
						array(
							'type' => 'codeeditor',
							'name' => 'ozy_logistic_custom_css',
							'label' => __('Custom CSS', 'logistic'),
							'description' => __('Write your custom css here. <strong>Please do not add "style" tags.</strong>', 'logistic'),
							'theme' => 'eclipse',
							'mode' => 'css',
						),
						array(
							'type' => 'codeeditor',
							'name' => 'ozy_logistic_custom_script',
							'label' => __('Custom JS', 'logistic'),
							'description' => __('Write your custom js here. Please do not add script tags into this box. <strong>Please do not add "script" tags.</strong>', 'logistic'),
							'theme' => 'mono_industrial',
							'mode' => 'javascript',
						),
					),
				),
			),
		),
		
		
		array(
			'title' => __('Typography', 'logistic'),
			'name' => 'ozy_logistic_typography',
			'icon' => 'font-awesome:fa-pencil',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => __('Extended Parameters', 'logistic'),
					'fields' => array(
						array(
							'type' => 'textbox',
							'name' => 'ozy_logistic_typography_google_param',
							'description' => 'Add extra parameters here. By this option, you can load non-latin charset or more types byt available parameters. Use like ":400,100,300,700".',
							'default' => ':100,200,300,400,500,600,700,800,900'
						),
					)
				),			
				array(
					'type' => 'section',
					'title' => __('Content Typography', 'logistic'),
					'fields' => array(
						array(
							'type' => 'html',
							'name' => 'ozy_logistic_typography_font_preview',
							'binding' => array(
								'field'    => 'ozy_logistic_typography_font_face,ozy_logistic_typography_font_style,ozy_logistic_typography_font_weight,ozy_logistic_typography_font_size, ozy_logistic_typography_font_line_height',
								'function' => 'vp_font_preview',
							),
						),
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_font_face',
							'label' => __('Font Face', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_gwf_family',
									),
								),
							),
							'default' => 'Raleway'
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_typography_font_style',
							'label' => __('Font Style', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_typography_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_typography_font_weight',
							'label' => __('Font Weight', 'logistic'),
							'default' => 'normal',
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_typography_font_face',
										'value' => 'vp_get_gwf_weight',
									),
								),
							),
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_font_size',
							'label'   => __('Font Size (px)', 'logistic'),
							'min'     => '5',
							'max'     => '86',
							'default' => '14',
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_font_line_height',
							'label'   => __('Line Height (em)', 'logistic'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),
					),
				),
				array(
					'type' => 'section',
					'title' => __('Heading Typography', 'logistic'),
					'fields' => array(
						array(
							'type' => 'html',
							'name' => 'ozy_logistic_typography_heading_font_preview',
							'binding' => array(
								'field'    => 'ozy_logistic_typography_heading_font_face,ozy_logistic_typography_heading_font_style,ozy_logistic_typography_heading_font_weight,ozy_logistic_typography_heading_h1_font_size',
								'function' => 'vp_font_preview_simple',
							),
						),
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_face',
							'label' => __('Font Face', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_gwf_family',
									),
								),
							),
							'default' => 'Raleway'
						)
					),
				),
				array(
					'type' => 'section',
					'title' => __('H1 Options', 'logistic'),
					'fields' => array(
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_h1_font_size',
							'label'   => __('H1 Size (px)', 'logistic'),
							'min'     => '5',
							'max'     => '128',
							'default' => '40',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_typography_heading_h1_font_style',
							'label' => __('H1 Font Style', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_weight_h1',
							'label' => __('H1 Weight', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'900',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_line_height_h1',
							'label'   => __('H1 Line Height (em)', 'logistic'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),					
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_ls_h1',
							'label' => __('H1 Letter Spacing', 'logistic'),
							'default' => 'normal',							
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => __('H2 Options', 'logistic'),
					'fields' => array(												
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_h2_font_size',
							'label'   => __('H2 Size (px)', 'logistic'),
							'min'     => '5',
							'max'     => '128',
							'default' => '30',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_typography_heading_h2_font_style',
							'label' => __('H2 Font Style', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'italic',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_weight_h2',
							'label' => __('H2 Weight', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'700',
							),
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_line_height_h2',
							'label'   => __('H2 Line Height (em)', 'logistic'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_ls_h2',
							'label' => __('H2 Letter Spacing', 'logistic'),
							'default' => 'normal',
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => __('H3 Options', 'logistic'),
					'fields' => array(						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_h3_font_size',
							'label'   => __('H3 Size (px)', 'logistic'),
							'min'     => '5',
							'max'     => '128',
							'default' => '22',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_typography_heading_h3_font_style',
							'label' => __('H3 Font Style', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_weight_h3',
							'label' => __('H3 Weight', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'700',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_line_height_h3',
							'label'   => __('H3 Line Height (em)', 'logistic'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_ls_h3',
							'label' => __('H3 Letter Spacing', 'logistic'),
							'default' => 'normal',							
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => __('H4 Options', 'logistic'),
					'fields' => array(						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_h4_font_size',
							'label'   => __('H4 Size (px)', 'logistic'),
							'min'     => '5',
							'max'     => '128',
							'default' => '18',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_typography_heading_h4_font_style',
							'label' => __('H4 Font Style', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_weight_h4',
							'label' => __('H4 Weight', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'700',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_line_height_h4',
							'label'   => __('H4 Line Height (em)', 'logistic'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_ls_h4',
							'label' => __('H4 Letter Spacing', 'logistic'),
							'default' => 'normal',							
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => __('H5 Options', 'logistic'),
					'fields' => array(						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_h5_font_size',
							'label'   => __('H5 Size (px)', 'logistic'),
							'min'     => '5',
							'max'     => '128',
							'default' => '16',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_typography_heading_h5_font_style',
							'label' => __('H5 Font Style', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_weight_h5',
							'label' => __('H5 Weight', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'600',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_line_height_h5',
							'label'   => __('H5 Line Height (em)', 'logistic'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_ls_h5',
							'label' => __('H5 Letter Spacing', 'logistic'),
							'default' => 'normal',							
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),
					),
				),
				array(
					'type' => 'section',
					'title' => __('H6 Options', 'logistic'),
					'fields' => array(						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_h6_font_size',
							'label'   => __('H6 Size (px)', 'logistic'),
							'min'     => '5',
							'max'     => '128',
							'default' => '12',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_typography_heading_h6_font_style',
							'label' => __('H6 Font Style', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_typography_heading_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_weight_h6',
							'label' => __('H6 Weight', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_weight_list',
									),
								),
							),
							'default' => array(
								'800',
							),							
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_typography_heading_line_height_h6',
							'label'   => __('H6 Line Height (em)', 'logistic'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),						
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_typography_heading_font_ls_h6',
							'label' => __('H6 Letter Spacing', 'logistic'),
							'default' => 'normal',
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_font_letter_spacing_list',
									),
								),
							),
						),						
					),
				),
				

				array(
					'type' => 'section',
					'title' => __('Primary Menu Typography', 'logistic'),
					'name' => 'ozy_logistic_primary_menu_section_typography',
					'fields' => array(
						array(
							'type' => 'select',
							'name' => 'ozy_logistic_primary_menu_typography_font_face',
							'label' => __('Font Face', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'function',
										'value' => 'vp_get_gwf_family',
									),
								),
							),
							'default' => 'Raleway'
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_primary_menu_typography_font_style',
							'label' => __('Font Style', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_primary_menu_typography_font_face',
										'value' => 'vp_get_gwf_style',
									),
								),
							),
							'default' => array(
								'normal',
							),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_primary_menu_typography_font_weight',
							'label' => __('Font Weight', 'logistic'),
							'items' => array(
								'data' => array(
									array(
										'source' => 'binding',
										'field' => 'ozy_logistic_primary_menu_typography_font_face',
										'value' => 'vp_get_gwf_weight',
									),
								),
							),
							'default' => array(
								'600',
							),
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_primary_menu_typography_font_size',
							'label'   => __('Font Size (px)', 'logistic'),
							'min'     => '5',
							'max'     => '128',
							'default' => '12',
						),
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_primary_menu_typography_font_size_overlay',
							'label'   => __('Font Size - Overlay Menu (px)', 'logistic'),
							'min'     => '5',
							'max'     => '128',
							'default' => '32',
						),						
						array(
							'type'    => 'slider',
							'name'    => 'ozy_logistic_primary_menu_typography_line_height',
							'label'   => __('Line Height (em)', 'logistic'),
							'min'     => '0',
							'max'     => '3',
							'default' => '1.5',
							'step'    => '0.1',
						),
					),
				),
								
			),
		),
		
				
		array(
			'title' => __('Layout', 'logistic'),
			'name' => 'ozy_logistic_layout',
			'icon' => 'font-awesome:fa-magic',
			'menus' => array(
				array(
					'title' => __('Primary Menu / Logo', 'logistic'),
					'name' => 'ozy_logistic_primary_menu',
					'icon' => 'font-awesome:fa-cogs',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => __('Primary Menu', 'logistic'),
							'name' => 'ozy_logistic_section_header_layout',
							'fields' => array(
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_primary_sticky_menu',
									'label' => esc_attr__('Sticky Menu', 'logistic'),
									'default' => 1
								),										
								array(
									'type'    => 'slider',
									'name'    => 'ozy_logistic_primary_menu_height',
									'label'   => __('Menu / Logo Height', 'logistic'),
									'description'   => __('Set this value to fit at least same as your logo height for perfect results', 'logistic'),
									'min'     => '40',
									'max'     => '500',
									'default' => '120',
								),								
								array(
									'type' => 'radiobutton',
									'name' => 'ozy_logistic_primary_menu_search',
									'label' => __('Search Button / Box', 'logistic'),
									'items' => array(
										array(
											'value' => '1',
											'label' => __('On', 'logistic'),
										),
										array(
											'value' => '-1',
											'label' => __('Off', 'logistic'),
										)
									),
									'default' => array(
										'1',
									),
								),						
								array(
									'type' => 'radiobutton',
									'name' => 'ozy_logistic_primary_menu_align',
									'label' => __('Menu Align', 'logistic'),
									'items' => array(
										array(
											'value' => 'left',
											'label' => __('Left', 'logistic'),
										),
										array(
											'value' => 'right',
											'label' => __('Right', 'logistic'),
										)									
									),
									'validation' => 'required',
									'default' => array(
										'right',
									),								
								),
								array(
									'type' => 'radiobutton',
									'name' => 'ozy_logistic_primary_menu_style',
									'label' => __('Menu Style', 'logistic'),
									'items' => array(
										array(
											'value' => 'classic',
											'label' => __('Classic', 'logistic'),
										),
										array(
											'value' => 'overlay',
											'label' => __('Overlay', 'logistic'),
										)									
									),
									'validation' => 'required',
									'default' => array(
										'classic',
									),								
								)								
							),
						),
						array(
							'type' => 'section',
							'title' => __('Logo', 'logistic'),
							'name' => 'ozy_logistic_section_image_logo',
							'description' => __('You can use custom image logo for your site. To use this option, first activate \'Use Custom Logo\' switch', 'logistic'),
							'fields' => array(				
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_use_custom_logo',
									'label' => __('Use Custom Logo', 'logistic'),
									'default' => 1,
									'description' => __('Use custom logo or text logo', 'logistic'),
								),
								array(
									'type' => 'upload',
									'name' => 'ozy_logistic_custom_logo',
									'label' => __('Custom Logo', 'logistic'),
									'default' => OZY_BASE_URL . 'images/logo.png',
									'dependency' => array(
										'field' => 'ozy_logistic_use_custom_logo',
										'function' => 'vp_dep_boolean',
									),
									'description' => __('Upload or choose custom logo', 'logistic'),
								),								
								array(
									'type' => 'upload',
									'name' => 'ozy_logistic_custom_logo_retina',
									'label' => __('Custom Logo Retina', 'logistic'),
									'default' => OZY_BASE_URL . 'images/logo@2x.png',
									'dependency' => array(
										'field' => 'ozy_logistic_use_custom_logo',
										'function' => 'vp_dep_boolean',
									),
									'description' => __('Upload or choose custom 2x bigger logo', 'logistic'),
								)							
							),
						),						
					),
				),
				
				
				array(
					'title' => __('Top Info Bar', 'logistic'),
					'name' => 'ozy_logistic_top_info_bar',
					'icon' => 'font-awesome:fa-cogs',
					'controls' => $top_info_bar_field_arr
				),				
				
				array(
					'title' => __('Footer', 'logistic'),
					'name' => 'ozy_logistic_footer',
					'icon' => 'font-awesome:fa-cog',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => __('Footer Layout', 'logistic'),
							'name' => 'ozy_logistic_section_footer_copyright',
							'fields' => $footer_copyright_array
						),
						array(
							'type' => 'section',
							'title' => __('Footer Layout', 'logistic'),
							'name' => 'ozy_logistic_section_footer_layout',
							'fields' => array(
								array(
									'type' => 'slider',
									'name' => 'ozy_logistic_footer_height',
									'label' => __('Footer Height', 'logistic'),
									'description' => __('Select height of your footer. Minimum value set to 30 and maximum set to 360. Will be processed in pixels.', 'logistic'),
									'min' => '30',
									'max' => '360',
									'step' => '1',
									'default' => '56',
								),
							),
						),
												
					),
				),				
				

				array(
					'title' => __('Content / Page / Post', 'logistic'),
					'name' => 'ozy_logistic_page',
					'icon' => 'font-awesome:fa-pencil',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => __('Page Position / Layout', 'logistic'),
							'name' => 'ozy_logistic_page_section_position',
							'description' => __('Select position for your page content', 'logistic'),
							'fields' => array(
								array(
									'type' => 'radiobutton',
									'name' => 'ozy_logistic_page_model',
									'label' => __('Default Page Model', 'logistic'),
									'items' => array(
										array(
											'value' => 'boxed',
											'label' => __('Boxed', 'logistic'),
										),
										array(
											'value' => 'full',
											'label' => __('Full', 'logistic'),
										),
									),
									'default' => array(
										'full',
									),
								),																								
							),
						),
						array(
							'type' => 'section',
							'title' => __('Custom 404 Page', 'logistic'),
							'name' => 'ozy_logistic_page_section_404_page',
							'description' => __('Select a page to use as your custom 404 (not found) page', 'logistic'),
							'fields' => array(
								array(
									'type' => 'select',
									'name' => 'ozy_logistic_page_404_page_id',
									'label' => __('Custom 404 Page', 'logistic'),
									'description' => __('Select a page to use as custom 4040 page.', 'logistic'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_logistic_pages',
											),
										),
									),
								)													
							),
						),							
						array(
							'type' => 'section',
							'title' => __('Page', 'logistic'),
							'name' => 'ozy_logistic_page_section_page_sidebar_position',
							'description' => __('Select position for your page sidebar', 'logistic'),
							'fields' => array(
								array(
									'type' => 'radioimage',
									'name' => 'ozy_logistic_page_page_sidebar_position',
									'label' => __('Default Sidebar Position', 'logistic'),
									'description' => __('Select one of available header type.', 'logistic'),
									'item_max_width' => '86',
									'items' => array(
										array(
											'value' => 'full',
											'label' => __('No Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/full-width.png',
										),
										array(
											'value' => 'left',
											'label' => __('Left Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/left-sidebar.png',
										),
										array(
											'value' => 'right',
											'label' => __('Right Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/right-sidebar.png',
										)
									),
									'default' => array(
										'{{first}}',
									),
								),
								array(
									'type' => 'select',
									'name' => 'ozy_logistic_page_page_sidebar_id',
									'label' => __('Default Sidebar', 'logistic'),
									'description' => __('This option could be overriden individually.', 'logistic'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_logistic_sidebars',
											),
										),
									),
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_page_page_comment',
									'label' => __('Comments Section', 'logistic'),
									'description' => __('Enable / Disable comment section on the pages', 'logistic'),
									'default' => '0',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_page_page_author',
									'label' => __('Author Section', 'logistic'),
									'description' => __('Enable / Disable author section on the pages', 'logistic'),
									'default' => '0',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_page_page_comment_closed',
									'label' => __('Show Comments Closed Message', 'logistic'),
									'description' => __('Whenever comments closed on a page or post a message appears, you can hide it.', 'logistic'),
									'default' => '0',
								),	
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_page_page_share',
									'label' => __('Share Buttons', 'logistic'),
									'description' => __('Enable / Disable share buttons for pages.', 'logistic'),
									'default' => '0',
								)															
							),
						),
						array(
							'type' => 'section',
							'title' => __('Blog', 'logistic'),
							'name' => 'ozy_logistic_page_section_blog_sidebar_position',
							'description' => __('Select position for your blog page sidebar', 'logistic'),
							'fields' => array(
								array(
									'type' => 'radioimage',
									'name' => 'ozy_logistic_page_blog_sidebar_position',
									'label' => __('Defaul Sidebar Position', 'logistic'),
									'description' => __('Select one of available header type.', 'logistic'),
									'item_max_width' => '86',
									'items' => array(
										array(
											'value' => 'full',
											'label' => __('No Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/full-width.png',
										),
										array(
											'value' => 'left',
											'label' => __('Left Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/left-sidebar.png',
										),
										array(
											'value' => 'right',
											'label' => __('Right Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/right-sidebar.png',
										)
									),
									'default' => array(
										'{{first}}',
									),
								),
								array(
									'type' => 'select',
									'name' => 'ozy_logistic_page_blog_sidebar_id',
									'label' => __('Default Sidebar', 'logistic'),
									'description' => __('This option could be overriden individually.', 'logistic'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_logistic_sidebars',
											),
										),
									),
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_page_blog_comment',
									'label' => __('Comments Section', 'logistic'),
									'description' => __('Enable / Disable comment section on the blog posts', 'logistic'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_page_blog_author',
									'label' => __('Author Section', 'logistic'),
									'description' => __('Enable / Disable author section on the blog posts', 'logistic'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_page_blog_share',
									'label' => __('Share Buttons', 'logistic'),
									'description' => __('Enable / Disable share buttons for posts.', 'logistic'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_page_blog_related_posts',
									'label' => __('Related Posts', 'logistic'),
									'description' => __('Enable / Disable related posts.', 'logistic'),
									'default' => '1',
								),
								array(
									'type' => 'select',
									'name' => 'ozy_logistic_page_blog_list_page_id',
									'label' => __('Default Listing Page', 'logistic'),
									'description' => __('Select a page to use as "Return to Blog" link.', 'logistic'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_logistic_pages',
											),
										),
									),
								)											
							),
						),
						array(
							'type' => 'section',
							'title' => __('WooCommerce', 'logistic'),
							'name' => 'ozy_logistic_page_section_woocommerce_sidebar_position',
							'description' => __('Select position for your WooCommerce page sidebar', 'logistic'),
							'fields' => array(
								array(
									'type' => 'radioimage',
									'name' => 'ozy_logistic_page_woocommerce_sidebar_position',
									'label' => __('Default Sidebar Position', 'logistic'),
									'description' => __('Select one of available header type.', 'logistic'),
									'item_max_width' => '86',
									'items' => array(
										array(
											'value' => 'full',
											'label' => __('No Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/full-width.png',
										),
										array(
											'value' => 'left',
											'label' => __('Left Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/left-sidebar.png',
										),
										array(
											'value' => 'right',
											'label' => __('Right Sidebar', 'logistic'),
											'img' => OZY_BASE_URL . 'admin/images/right-sidebar.png',
										)
									),
									'default' => array(
										'{{first}}',
									),
								),
								array(
									'type' => 'select',
									'name' => 'ozy_logistic_page_woocommerce_sidebar_id',
									'label' => __('Default Sidebar', 'logistic'),
									'description' => __('This option could be overriden individually.', 'logistic'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_bind_ozy_logistic_sidebars',
											),
										),
									),
								),												
							),
						),												
					),
				),	
				
				
				array(
					'title' => __('Miscellaneous', 'logistic'),
					'name' => 'ozy_logistic_misc',
					'icon' => 'font-awesome:fa-puzzle-piece',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => __('Fancy Box (Lightbox)', 'logistic'),
							'name' => 'ozy_logistic_section_fancybox_layout',
							'fields' => array(
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_fancbox_media',
									'label' => __('Video Support', 'logistic'),
									'description' => __('By enabling this option Fancybox will start to support popular media links.', 'logistic'),
									'default' => '1',
								),
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_fancbox_thumbnail',
									'label' => __('Thumbnail', 'logistic'),
									'description' => __('Enable this option to show thumnails under your Fancybox window.', 'logistic'),
									'default' => '0',
								),								
							),
						),
						
						array(
							'type' => 'section',
							'title' => esc_attr__('Global Loading Screen', 'logistic'),
							'name' => 'ozy_logistic_section_animsition_layout',
							'fields' => array(
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_disable_animsition',
									'label' => esc_attr__('Disable Loading Screen', 'logistic'),
									'description' => esc_attr__('Loading screen and page transition on this page will be disable.', 'logistic'),
									'default' => '0',
								)							
							),
						),							
					),
				),
				array(
					'title' => __('Countdown Page', 'logistic'),
					'name' => 'ozy_logistic_countdown',
					'icon' => 'font-awesome:fa-clock-o',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => __('Countdown Page Options', 'logistic'),
							'name' => 'ozy_logistic_section_countdown',
							'fields' => array(
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_countdown_year',
									'label' => __('End Year', 'logistic'),
									'description' => __('Enter the Year of the date counter will count to.', 'logistic'),
									'default' => date('Y', time())
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_countdown_month',
									'label' => __('End Month', 'logistic'),
									'description' => __('Enter the Month of the date counter will count to.', 'logistic'),
									'default' => date('m', time())
								),								
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_countdown_day',
									'label' => __('End Day', 'logistic'),
									'description' => __('Enter the Day of the date counter will count to.', 'logistic'),
									'default' => '15'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_countdown_hour',
									'label' => __('End Hour', 'logistic'),
									'description' => __('Enter the Hour of the date counter will count to.', 'logistic'),
									'default' => '12'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_countdown_minute',
									'label' => __('End Minute', 'logistic'),
									'description' => __('Enter the Minute of the date counter will count to.', 'logistic'),
									'default' => '12'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_countdown_second',
									'label' => __('End Second', 'logistic'),
									'description' => __('Enter the Second of the date counter will count to.', 'logistic'),
									'default' => '00'
								)		
							),
						),
												
					),
				),			
			),
		),
		array(
			'name' => 'ozy_logistic_color_options',
			'title' => __('Color Options', 'logistic'),
			'icon' => 'font-awesome:fa-eye',
			'controls' => array(
							
				array(
					'type' => 'section',
					'title' => __('GENERIC', 'logistic'),
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_content_background_color',
							'label' => __('Content Background', 'logistic'),
							'format' => 'rgba',
							'default' => 'rgba(255,255,255,1)'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_content_color',
							'label' => __('Content Color', 'logistic'),
							'description' => __('Font color of the content', 'logistic'),
							'format' => 'hex',
							'default' => '#000000'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_content_color_alternate',
							'label' => __('Alternate Color #1', 'logistic'),
							'description' => __('Like link color, hover color and input elements active border', 'logistic'),
							'format' => 'hex',
							'default' => '#34ccff'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_content_color_alternate2',
							'label' => __('Alternate Color #2', 'logistic'),
							'description' => __('Like footer, footer sidebar title color, text color and seperator color', 'logistic'),
							'format' => 'hex',
							'default' => '#000000'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_content_color_alternate3',
							'label' => __('Alternate Color #3', 'logistic'),
							'description' => __('Like footer sidebar link color', 'logistic'),
							'format' => 'hex',
							'default' => '#ffffff'
						),						
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_content_background_color_alternate',
							'label' => __('Alternate Background Color', 'logistic'),
							'description' => __('Like comments background color', 'logistic'),
							'format' => 'rgba',
							'default' => 'rgba(240,240,240,1)'
						),						
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_separator_color',
							'label' => __('Separator / Border Color', 'logistic'),
							'description' => __('Used for, Primary menu, in page Seperators and Comments bottom border', 'logistic'),
							'default' => 'rgba(240,240,240,1)',
							'format' => 'rgba'
						),						
					),
				),
				
				array(
					'type' => 'section',
					'title' => __('Top Info Bar', 'logistic'),
					'name' => 'ozy_logistic_top_info_bar_section_coloring',
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_top_info_bar_font_color',
							'label' => __('Font Color', 'logistic'),
							'default' => '#ffffff',
							'format' => 'hex',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_top_info_bar_background_color1',
							'label' => __('Background Color Start', 'logistic'),
							'default' => '#0076ff',
							'format' => 'hex',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_top_info_bar_background_color2',
							'label' => __('Background Color End', 'logistic'),
							'default' => '#1fd87c',
							'format' => 'hex',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_top_info_bar_background_color3',
							'label' => __('Switcher', 'logistic'),
							'default' => '#fff',
							'format' => 'hex',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_top_info_bar_background_color4',
							'label' => __('Switcher Hover', 'logistic'),
							'default' => '#000',
							'format' => 'hex',
						)														
					),
				),				
				
				array(
					'type' => 'section',
					'title' => __('Primary Menu', 'logistic'),
					'name' => 'ozy_logistic_primary_menu_section_colors',
					'fields' => array(			
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_logo_color',
							'label' => __('Text Logo Color', 'logistic'),
							'default' => 'rgba(0,0,0,1)',
							'format' => 'rgba',
							'description' => 'Available only when one or both logo image not supplied',
						),					
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_font_color',
							'label' => __('Font Color', 'logistic'),
							'default' => 'rgba(0,0,0,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_font_color_hover',
							'label' => __('Font Color : Hover / Active', 'logistic'),
							'default' => 'rgba(52,204,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_background_color',
							'label' => __('Background Color', 'logistic'),
							'default' => 'rgba(255,255,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_background_color_hover',
							'label' => __('Background Color : Hover / Active', 'logistic'),
							'default' => 'rgba(32,32,32,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_separator_color_2',
							'label' => __('Separator Color', 'logistic'),
							'default' => 'rgba(235,235,235,1)',
							'format' => 'rgba',
						),
					),
				),		

				array(
					'type' => 'section',
					'title' => __('Primary Menu - Overlay', 'logistic'),
					'name' => 'ozy_logistic_primary_menu_section_colors_overlay',
					'fields' => array(		
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_font_color_overlay',
							'label' => __('Font Color', 'logistic'),
							'default' => 'rgba(255,255,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_font_color_hover_overlay',
							'label' => __('Font Color : Hover / Active', 'logistic'),
							'default' => 'rgba(0,0,0,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_primary_menu_background_color_overlay',
							'label' => __('Background Color', 'logistic'),
							'default' => 'rgba(52,204,255,0.9)',
							'format' => 'rgba',
						)
					),
				),	
										
				array(
					'type' => 'section',
					'title' => __('Footer', 'logistic'),
					'name' => 'ozy_logistic_footer_section_colors',
					'fields' => array(
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_footer_background_image',
							'label' => __('Background Image', 'logistic'),
							'description' => __('Upload or choose custom page background image.', 'logistic'),
							'default' => OZY_BASE_URL . 'images/assets/footer_bg.jpg'
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_footer_color_1',
							'label' => __('Background Color', 'logistic'),
							'default' => 'rgba(23,27,38,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_footer_color_2',
							'label' => __('Foreground Color', 'logistic'),
							'default' => '#ffffff',
							'format' => 'hex',
						),					
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_footer_color_3',
							'label' => __('Alternate Color', 'logistic'),
							'default' => '#34ccff',
							'format' => 'hex',
						),					
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_footer_color_4',
							'label' => __('Separator Color', 'logistic'),
							'default' => '#2f323c',
							'format' => 'hex',
						)
					),
				),
				array(
					'type' => 'section',
					'title' => __('Form', 'logistic'),
					'name' => 'ozy_logistic_form_section_coloring',
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_form_font_color',
							'label' => __('Font Color', 'logistic'),
							'default' => 'rgba(35,35,35,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_form_background_color',
							'label' => __('Background Color', 'logistic'),
							'default' => 'rgba(255,255,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_form_button_font_color',
							'label' => __('Font Color (Button)', 'logistic'),
							'default' => 'rgba(255,255,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_form_button_font_color_hover',
							'label' => __('Font Color : Hover / Active (Button)', 'logistic'),
							'default' => 'rgba(255,255,255,1)',
							'format' => 'rgba',
						),
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_form_button_background_color',
							'label' => __('Background Color (Button)', 'logistic'),
							'default' => 'rgba(0,0,0,1)',
							'format' => 'rgba',
						),	
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_form_button_background_color_hover',
							'label' => __('Background Color : Hover / Active (Button)', 'logistic'),
							'default' => 'rgba(52,204,255,1)',
							'format' => 'rgba',
						),											
					),
				),
				array(
					'type' => 'section',
					'title' => __('Background Styling', 'logistic'),
					'fields' => array(
						array(
							'type' => 'color',
							'name' => 'ozy_logistic_body_background_color',
							'label' => __('Background Color', 'logistic'),
							'description' => __('This option will affect only page background.', 'logistic'),
							'default' => '#000000',
							'format' => 'hex',
						),					
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_body_background_image',
							'label' => __('Custom Background Image', 'logistic'),
							'description' => __('Upload or choose custom page background image.', 'logistic'),
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_body_background_image_size',
							'label' => __('Background Image Size', 'logistic'),
							'description' => __('Only available on browsers which supports CSS3.', 'logistic'),
							'items' => array(
								array(
									'value' => '',
									'label' => __('-not set-', 'logistic'),
								),			
								array(
									'value' => 'cover',
									'label' => __('cover', 'logistic'),
								),
								array(
									'value' => 'contain',
									'label' => __('contain', 'logistic'),
								)
							),
							'default' => '{{first}}',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_body_background_image_repeat',
							'label' => __('Background Image Repeat', 'logistic'),
							'items' => array(
								array(
									'value' => 'inherit',
									'label' => __('inherit', 'logistic'),
								),			
								array(
									'value' => 'no-repeat',
									'label' => __('no-repeat', 'logistic'),
								),
								array(
									'value' => 'repeat',
									'label' => __('repeat', 'logistic'),
								),
								array(
									'value' => 'repeat-x',
									'label' => __('repeat-x', 'logistic'),
								),
								array(
									'value' => 'repeat-y',
									'label' => __('repeat-y', 'logistic'),
								)
							),
							'default' => '{{first}}',
						),
						array(
							'type' => 'radiobutton',
							'name' => 'ozy_logistic_body_background_image_attachment',
							'label' => __('Background Image Attachment', 'logistic'),
							'items' => array(
								array(
									'value' => '',
									'label' => __('-not set-', 'logistic'),
								),			
								array(
									'value' => 'fixed',
									'label' => __('fixed', 'logistic'),
								),
								array(
									'value' => 'scroll',
									'label' => __('scroll', 'logistic'),
								),
								array(
									'value' => 'local',
									'label' => __('local', 'logistic')
								)
							),
							'default' => '{{first}}',
						),			
					),
				),
				
			),
		),			
		
		array(
			'title' => __('Social', 'logistic'),
			'name' => 'ozy_logistic_typography',
			'icon' => 'font-awesome:fa-group',
			'menus' => array(
				array(
					'title' => __('Accounts', 'logistic'),
					'name' => 'ozy_logistic_social_accounts',
					'icon' => 'font-awesome:fa-heart-o',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => __('Social Accounts', 'logistic'),
							'description' => __('Enter social account names/IDs box below', 'logistic'),
							'fields' => array(
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_fivehundredpx',
									'label' => __('500px', 'logistic')
								),							
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_behance',
									'label' => __('Behance', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_blogger',
									'label' => __('Blogger', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_delicious',
									'label' => __('Delicious', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_deviantart',
									'label' => __('DeviantArt', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_digg',
									'label' => __('Digg', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_dribble',
									'label' => __('Dribble', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_email',
									'label' => __('Email', 'logistic'),
									'default' => '#'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_facebook',
									'label' => __('Facebook', 'logistic'),
									'default' => '#'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_flickr',
									'label' => __('Flickr', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_forrst',
									'label' => __('Forrst', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_foursquare',
									'label' => __('Foursquare', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_github',
									'label' => __('Github', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_googleplus',
									'label' => __('Google+', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_instagram',
									'label' => __('Instagram', 'logistic'),
									'default' => '#'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_lastfm',
									'label' => __('Last.FM', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_linkedin',
									'label' => __('LinkedIn', 'logistic')
								),

								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_myspace',
									'label' => __('MySpace', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_pinterest',
									'label' => __('Pinterest', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_rss',
									'label' => __('RSS', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_soundcloud',
									'label' => __('SoundCloud', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_stumbleupon',
									'label' => __('StumbleUpon', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_tumblr',
									'label' => __('Tumblr', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_twitter',
									'label' => __('Twitter', 'logistic'),
									'default' => '#'
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_vimeo',
									'label' => __('Vimeo', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_wordpress',
									'label' => __('WordPress', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_yahoo',
									'label' => __('Yahoo!', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_youtube',
									'label' => __('YouTube', 'logistic')
								),
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_yelp',
									'label' => __('Yelp (Please use full URL)', 'logistic')
								),								
								array(
									'type' => 'textbox',
									'name' => 'ozy_logistic_social_accounts_vk',
									'label' => __('VK', 'logistic')
								),																																																																																																																																																																																																					
							),
						),
					),
				),			
				array(
					'title' => __('General', 'logistic'),
					'name' => 'ozy_logistic_social_general',
					'icon' => 'font-awesome:fa-group',
					'controls' => array(
						array(
							'type' => 'section',
							'title' => __('Social Icons', 'logistic'),
							'fields' => array(
								array(
									'type' => 'toggle',
									'name' => 'ozy_logistic_social_use',
									'label' => __('Social Share Buttons', 'logistic'),
									'description' => __('Enable / Disable social share buttons.', 'logistic'),
									'default' => '1',
								),
								array(
									'type' => 'sorter',
									'name' => 'ozy_logistic_social_icon_order',
									'max_selection' => 20,
									'label' => __('Icon List / Order', 'logistic'),
									'description' => __('Select visible icons and sort.', 'logistic'),
									'items' => array(
										'data' => array(
											array(
												'source' => 'function',
												'value' => 'vp_get_social_medias',
											),
										),
									),
									'default' => array('email', 'facebook', 'instagram', 'twitter')
								),
								array(
									'type' => 'select',
									'name' => 'ozy_logistic_social_icon_target',
									'label' => __('Target Window', 'logistic'),
									'description' => __('Where links will be opened?', 'logistic'),
									'items' => array(
										array(
											'value' => '_blank',
											'label' => __('Blank Window / New Tab', 'logistic'),
										),
										array(
											'value' => '_self',
											'label' => __('Self Window', 'logistic'),
										),
									),
									'default' => array(
										'_blank',
									),
								),								
							),
						),
					),
				),			
			),
		),
	)
);

return $ozy_logistic_option_arr;

/**
 *EOF
 */