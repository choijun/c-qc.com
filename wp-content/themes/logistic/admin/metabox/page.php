<?php

return array(
	'id'          => 'ozy_logistic_meta_page',
	'types'       => array('page'),
	'title'       => __('Page Options', 'logistic'),
	'priority'    => 'high',
	'template'    => array(
		array(
			'type' => 'select',
			'name' => 'ozy_logistic_meta_page_custom_menu',
			'label' => __('Custom Menu', 'logistic'),
			'description' => __('You can select a custom menu for this page.', 'logistic'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_logistic_list_wp_menus',
					),
				),
			),
			'default' => '-1',
		),
		array(
			'type' => 'select',
			'name' => 'ozy_logistic_meta_page_revolution_slider',
			'label' => __('Revolution Header Slider', 'logistic'),
			'description' => __('You can select a header slider if you have installed and activated Revolution Slider which comes bundled with your theme.', 'logistic'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_logistic_revolution_slider',
					),
				),
			),
			'default' => '{{first}}',
		),
		array(
			'type' => 'select',
			'name' => 'ozy_logistic_meta_page_master_slider',
			'label' => __('Master Header Slider', 'logistic'),
			'description' => __('You can select a header slider if you have installed and activated Master Slider which comes bundled with your theme.', 'logistic'),
			'items' => array(
				'data' => array(
					array(
						'source' => 'function',
						'value' => 'vp_bind_ozy_logistic_master_slider',
					),
				),
			),
			'default' => '{{first}}',
		),		


		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_use_footer_slider',
			'label' => __('Use Footer Slider', 'logistic'),
			'description' => __('You can use footer slider with header slider too.', 'logistic'),
		),
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_logistic_meta_page_use_footer_slider_group',
			'title'     => __('Footer Slider', 'logistic'),
			'dependency' => array(
				'field'    => 'ozy_logistic_meta_page_use_footer_slider',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(
				array(
					'type' => 'select',
					'name' => 'ozy_logistic_meta_page_revolution_footer_slider',
					'label' => __('Revolution Footer Slider', 'logistic'),
					'description' => __('You can select a footer slider if you have installed and activated Revolution Slider which comes bundled with your theme.', 'logistic'),
					'items' => array(
						'data' => array(
							array(
								'source' => 'function',
								'value' => 'vp_bind_ozy_logistic_revolution_slider',
							),
						),
					),
					'default' => '{{first}}',
				),
				array(
					'type' => 'select',
					'name' => 'ozy_logistic_meta_page_master_footer_slider',
					'label' => __('Master Footer Slider', 'logistic'),
					'description' => __('You can select a footer slider if you have installed and activated Master Slider which comes bundled with your theme.', 'logistic'),
					'items' => array(
						'data' => array(
							array(
								'source' => 'function',
								'value' => 'vp_bind_ozy_logistic_master_slider',
							),
						),
					),
					'default' => '{{first}}',
				),				
			),
		),
		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_disable_loader',
			'label' => __('Disable Loading Screen', 'logistic'),
			'description' => __('Check this option to disable page transition / loading screen for this page.', 'logistic'),
		),
		array(
			'type' => 'radiobutton',
			'name' => 'ozy_logistic_meta_page_hide_footer_widget_bar',
			'label' => __('Footer Bars Visiblity', 'logistic'),
			'description' => __('By this option you can hide footer bars as you wish.', 'logistic'),
			'items' => array(
				array(
					'value' => '-1',
					'label' => __('All Visible', 'logistic'),
				),
				array(
					'value' => '1',
					'label' => __('Hide Widget Bar', 'logistic'),
				),
				array(
					'value' => '2',
					'label' => __('Hide Widget Bar and Footer', 'logistic'),
				),
			),
			'default' => array(
				'-1',
			),
		),
		


		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_hide_title',
			'label' => __('Hide Page Title', 'logistic'),
			'description' => __('Page title will not be shown on the page.', 'logistic'),
		),
		
		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_use_no_content_padding',
			'label' => __('No content top padding', 'logistic'),
			'description' => __('Check this option to disable the padding top of your content (after page title).', 'logistic'),
		),		
		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_use_custom_title',
			'label' => __('Custom Header/Title', 'logistic'),
			'description' => __('There are several options to help you customize your page header.', 'logistic'),
		),
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_logistic_meta_page_use_custom_title_group',
			'title'     => __('Custom Header/Title Options', 'logistic'),
			'dependency' => array(
				'field'    => 'ozy_logistic_meta_page_use_custom_title',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(	
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_logistic_meta_page_custom_title_position',
					'label' => __('Title Position', 'logistic'),
					'items' => array(
						array(
							'value' => 'left',
							'label' => __('Left', 'logistic'),
						),
						array(
							'value' => 'right',
							'label' => __('Right', 'logistic'),
						),
						array(
							'value' => 'center',
							'label' => __('Center', 'logistic'),
						),
					),
					'default' => array(
						'left',
					),
				),			
				array(
					'type'      => 'textbox',
					'name'      => 'ozy_logistic_meta_page_custom_title',
					'label'     => __('Page Title', 'logistic'),
				),
				array(
					'type'      => 'color',
					'name'      => 'ozy_logistic_meta_page_custom_title_color',
					'label'     => __('Title Color', 'logistic'),
					'default' => '',
					'format' => 'rgba'
				),				
				array(
					'type'      => 'textbox',
					'name'      => 'ozy_logistic_meta_page_custom_sub_title',
					'label'     => __('Sub Title', 'logistic'),
				),
				array(
					'type'      => 'color',
					'name'      => 'ozy_logistic_meta_page_custom_sub_title_color',
					'label'     => __('Sub Title Color', 'logistic'),
					'default' => '',
					'format' => 'rgba'
				),				
				array(
					'type'      => 'color',
					'name'      => 'ozy_logistic_meta_page_custom_title_bgcolor',
					'label'     => __('Header Background Color', 'logistic'),
					'default' => '',
					'format' => 'rgba'
				),				
				array(
					'type'      => 'upload',
					'name'      => 'ozy_logistic_meta_page_custom_title_bg',
					'label'     => __('Header Image', 'logistic'),
					'description'=> __('Please use images like 1600px, 2000px wide and have a minimum height like 475px for good results.', 'logistic'),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_logistic_meta_page_custom_title_bg_x_position',
					'label' => __('Background X-Position', 'logistic'),
					'items' => array(
						array(
							'value' => 'left',
							'label' => __('Left', 'logistic'),
						),
						array(
							'value' => 'right',
							'label' => __('Right', 'logistic'),
						),
						array(
							'value' => 'center',
							'label' => __('Center', 'logistic'),
						),
						array(
							'value' => 'top',
							'label' => __('Top', 'logistic'),
						),
						array(
							'value' => 'bottom',
							'label' => __('Bottom', 'logistic'),
						),
					),
					'default' => array(
						'left',
					),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_logistic_meta_page_custom_title_bg_y_position',
					'label' => __('Background Y-Position', 'logistic'),
					'items' => array(
						array(
							'value' => 'left',
							'label' => __('Left', 'logistic'),
						),
						array(
							'value' => 'right',
							'label' => __('Right', 'logistic'),
						),
						array(
							'value' => 'center',
							'label' => __('Center', 'logistic'),
						),
						array(
							'value' => 'top',
							'label' => __('Top', 'logistic'),
						),
						array(
							'value' => 'bottom',
							'label' => __('Bottom', 'logistic'),
						),
					),
					'default' => array(
						'top',
					),
				),				
				array(
					'type'      => 'textbox',
					'name'      => 'ozy_logistic_meta_page_custom_title_height',
					'label'     => __('Header Height', 'logistic'),
					'description'=> __('Height of your header in pixels? Don\'t include "px" in the string. e.g. 400', 'logistic'),
					'default'	=> 100,
					'validation' => 'numeric'
				),				
			),
		),
		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_hide_content',
			'label' => __('Hide Page Content', 'logistic'),
			'description' => __('Page content will not be shown. Supposed to use with Video backgrounds or Fullscreen sliders.', 'logistic'),
		),		
		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_use_sidebar',
			'label' => __('Use Custom Sidebar', 'logistic'),
			'description' => __('You can use custom sidebar individually.', 'logistic'),
		),
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_logistic_meta_page_sidebar_group',
			'title'     => __('Custom Sidebar', 'logistic'),
			'dependency' => array(
				'field'    => 'ozy_logistic_meta_page_use_sidebar',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(
				array(
					'type' => 'radioimage',
					'name' => 'ozy_logistic_meta_page_sidebar_position',
					'label' => __('Sidebar Position', 'logistic'),
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
					'default' => '{{first}}',
				),			
				array(
					'type' => 'select',
					'name' => 'ozy_logistic_meta_page_sidebar',
					'label' => __('Sidebar', 'logistic'),
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
		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_use_custom_style',
			'label' => __('Use Custom Style', 'logistic'),
			'description' => __('Options to customize your page individually.', 'logistic'),
		),
		array(
			'type'      => 'group',
			'repeating' => false,
			'length'    => 1,
			'name'      => 'ozy_logistic_meta_page_layout_group',
			'title'     => __('Layout Styling', 'logistic'),
			'dependency' => array(
				'field'    => 'ozy_logistic_meta_page_use_custom_style',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(					
				array(
					'type' => 'color',
					'name' => 'ozy_logistic_meta_page_layout_ascend_background',
					'label' => __('Background Color', 'logistic'),
					'description' => __('This option will affect, main wrapper\'s background color.', 'logistic'),
					'default' => 'rgba(255,255,255,1)',
					'format' => 'rgba',
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_logistic_meta_page_layout_transparent_background',
					'label' => __('Transparent Content Background', 'logistic'),
					'description' => __('If you want, you can use transparent background for your content.', 'logistic'),
					'default' => '0',
				)														
			),
		),
		array(
			'type' => 'toggle',
			'name' => 'ozy_logistic_meta_page_use_custom_background',
			'label' => __('Use Custom Background', 'logistic'),
			'description' => __('Lots of options to customize your page background individually.', 'logistic'),
		),		
		array(
			'type'      => 'group',
			'repeating' => false,
			'name'      => 'ozy_logistic_meta_page_background_group',
			'title'     => __('Background Styling', 'logistic'),
			'dependency' => array(
				'field'    => 'ozy_logistic_meta_page_use_custom_background',
				'function' => 'vp_dep_boolean',
			),
			'fields'    => array(					
				array(
					'type' => 'upload',
					'name' => 'ozy_logistic_meta_page_background_image',
					'label' => __('Custom Background Image', 'logistic'),
					'description' => __('Upload or choose custom page background image.', 'logistic'),
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_logistic_meta_page_background_image_size',
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
					'name' => 'ozy_logistic_meta_page_background_image_pos_x',
					'label' => __('Background Position X', 'logistic'),
					'items' => array(
						array(
							'value' => 'left',
							'label' => __('left', 'logistic'),
						),			
						array(
							'value' => 'center',
							'label' => __('center', 'logistic'),
						),
						array(
							'value' => 'right',
							'label' => __('right', 'logistic'),
						)
					),
					'default' => 'left',
				),
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_logistic_meta_page_background_image_pos_y',
					'label' => __('Background Position Y', 'logistic'),
					'items' => array(
						array(
							'value' => 'top',
							'label' => __('top', 'logistic'),
						),			
						array(
							'value' => 'center',
							'label' => __('center', 'logistic'),
						),
						array(
							'value' => 'bottom',
							'label' => __('bottom', 'logistic'),
						)
					),
					'default' => 'top',
				),				
				
				array(
					'type' => 'radiobutton',
					'name' => 'ozy_logistic_meta_page_background_image_repeat',
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
					'name' => 'ozy_logistic_meta_page_background_image_attachment',
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
				array(
					'type' => 'color',
					'name' => 'ozy_logistic_meta_page_background_color',
					'label' => __('Background Color', 'logistic'),
					'description' => __('This option will affect only page background.', 'logistic'),
					'default' => '#ffffff',
					'format' => 'hex',
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_logistic_meta_page_background_use_gmap',
					'label' => __('Use Google Map', 'logistic'),
					'description' => __('Instead of using a static background, you can use a Google Map as background.', 'logistic'),
				),					
				array(
					'type'      => 'group',
					'repeating' => false,
					'name'      => 'ozy_logistic_meta_page_background_gmap_group',
					'title'     => __('Google Map', 'logistic'),
					'dependency' => array(
						'field'    => 'ozy_logistic_meta_page_background_use_gmap',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'textbox',
							'name' => 'ozy_logistic_meta_page_background_gmap_address',
							'label' => __('iFrame Src', 'logistic'),
							'description' => __('Enter src attribute of your Google Map iFrame.', 'logistic'),
						)												
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_logistic_meta_page_background_use_slider',
					'label' => __('Use Background Slider', 'logistic'),
					'description' => __('Instead of using a static background, you can use background image slider.', 'logistic'),
				),					
				array(
					'type'      => 'group',
					'repeating' => true,
					'sortable' => true,
					'name'      => 'ozy_logistic_meta_page_background_slider_group',
					'title'     => __('Slider Image', 'logistic'),
					'dependency' => array(
						'field'    => 'ozy_logistic_meta_page_background_use_slider',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_meta_page_background_slider_image',
							'label' => __('Slider Image', 'logistic'),
							'description' => __('Upload or choose custom background image.', 'logistic'),
						)												
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_logistic_meta_page_background_use_video_self',
					'label' => __('Use Self Hosted Video', 'logistic'),
					'description' => __('Instead of using a static background, you can use self hosted video.', 'logistic'),
				),					
				array(
					'type'      => 'group',
					'repeating' => false,
					'sortable' => false,
					'name'      => 'ozy_logistic_meta_page_background_video_self_group',
					'title'     => __('Self Hosted Video', 'logistic'),
					'dependency' => array(
						'field'    => 'ozy_logistic_meta_page_background_use_video_self',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_meta_page_background_video_self_image',
							'label' => __('Poster Image', 'logistic'),
							'description' => __('Upload or choose a poster image.', 'logistic'),
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_meta_page_background_video_self_mp4',
							'label' => __('MP4 File', 'logistic'),
							'description' => __('Upload or choose a MP4 file.', 'logistic'),
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_meta_page_background_video_self_webm',
							'label' => __('WEBM File', 'logistic'),
							'description' => __('Upload or choose a WEBM file.', 'logistic'),
						),
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_meta_page_background_video_self_ogv',
							'label' => __('OGV File', 'logistic'),
							'description' => __('Upload or choose an OGV file.', 'logistic'),
						)
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_logistic_meta_page_background_use_video_youtube',
					'label' => __('Use YouTube Video', 'logistic'),
					'description' => __('Instead of using a static background, you can use YouTube video.', 'logistic'),
				),					
				array(
					'type'      => 'group',
					'repeating' => false,
					'sortable' => false,
					'name'      => 'ozy_logistic_meta_page_background_video_youtube_group',
					'title'     => __('YouTube Video', 'logistic'),
					'dependency' => array(
						'field'    => 'ozy_logistic_meta_page_background_use_video_youtube',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_meta_page_background_video_youtube_image',
							'label' => __('Poster Image', 'logistic'),
							'description' => __('Upload or choose a poster image.', 'logistic'),
						),
						array(
							'type' => 'textbox',
							'name' => 'ozy_logistic_meta_page_background_video_youtube_id',
							'label' => __('YouTube Video ID', 'logistic'),
							'description' => __('Enter YouTube video ID. http://www.youtube.com/watch?v=<span style="color:red;">mYKA-VokOtA</span> text marked with red is the ID you have to be looking for.', 'logistic'),
						)
					),
				),
				array(
					'type' => 'toggle',
					'name' => 'ozy_logistic_meta_page_background_use_video_vimeo',
					'label' => __('Use Vimeo Video', 'logistic'),
					'description' => __('Instead of using a static background, you can use Vimeo video.', 'logistic'),
				),					
				array(
					'type'      => 'group',
					'repeating' => false,
					'sortable' => false,
					'name'      => 'ozy_logistic_meta_page_background_video_vimeo_group',
					'title'     => __('Vimeo Video', 'logistic'),
					'dependency' => array(
						'field'    => 'ozy_logistic_meta_page_background_use_video_vimeo',
						'function' => 'vp_dep_boolean',
					),
					'fields'    => array(					
						array(
							'type' => 'upload',
							'name' => 'ozy_logistic_meta_page_background_video_vimeo_image',
							'label' => __('Poster Image', 'logistic'),
							'description' => __('Upload or choose a poster image.', 'logistic'),
						),
						array(
							'type' => 'textbox',
							'name' => 'ozy_logistic_meta_page_background_video_vimeo_id',
							'label' => __('Vimeo Video ID', 'logistic'),
							'description' => __('Enter Vimeo video ID. http://vimeo.com/<span style="color:red;">71964690</span> text marked with red is the ID you have to be looking for.', 'logistic'),
						)
					),
				)
			),
		),
		array(
			'type' => 'radiobutton',
			'name' => 'ozy_logistic_meta_page_page_model',
			'label' => __('Default Page Model', 'logistic'),
			'items' => array(
				array(
					'value' => 'generic',
					'label' => __('Use From Theme Options', 'logistic'),
				),			
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
				'{{first}}',
			),
		)				
	),	
);

/**
 * EOF
 */