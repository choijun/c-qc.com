<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Offcanvas Content Widget
 */
class PP_Offcanvas_Content_Widget extends Widget_Base {
    
    /**
	 * Retrieve offcanvas content widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
    public function get_name() {
        return 'pp-offcanvas-content';
    }

    /**
	 * Retrieve offcanvas content widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
    public function get_title() {
        return __( 'Offcanvas Content', 'power-pack' );
    }

    /**
	 * Retrieve the list of categories the offcanvas content widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
    public function get_categories() {
        return [ 'power-pack' ];
    }

    /**
	 * Retrieve offcanvas content widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
    public function get_icon() {
        return 'fa fa-window-restore power-pack-admin-icon';
    }
    
    /**
	 * Retrieve the list of scripts the offcanvas content widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
    public function get_script_depends() {
        return [
            'pp-offcanvas-content',
            'pp-scripts'
        ];
    }

    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	CONTENT TAB
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Content Tab: Offcanvas Content
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_modal_popup',
            [
                'label'                 => __( 'Offcanvas Content', 'power-pack' ),
            ]
        );

        $this->add_control(
            'content_type',
            [
                'label'                 => __( 'Content Type', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                    'sidebar'   => __( 'Sidebar', 'power-pack' ),
                    'custom'    => __( 'Custom Content', 'power-pack' ),
                    'template'  => __( 'Saved Template', 'power-pack' ),
                ],
                'default'               => 'sidebar',
            ]
        );
        
        global $wp_registered_sidebars;

		$options = [];

		if ( ! $wp_registered_sidebars ) {
			$options[''] = __( 'No sidebars were found', 'power-pack' );
		} else {
			$options[''] = __( 'Choose Sidebar', 'power-pack' );

			foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
				$options[ $sidebar_id ] = $sidebar['name'];
			}
		}

		$default_key = array_keys( $options );
		$default_key = array_shift( $default_key );

		$this->add_control(
            'sidebar',
            [
                'label'                 => __( 'Choose Sidebar', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => $default_key,
                'options'               => $options,
				'condition'             => [
					'content_type' => 'sidebar',
				],
            ]
        );

        $this->add_control(
            'templates',
            [
                'label'                 => __( 'Choose Template', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => pp_get_page_templates(),
				'condition'             => [
					'content_type'    => 'template',
				],
            ]
        );
        
        $this->add_control(
			'custom_content',
			[
				'label'                 => '',
				'type'                  => Controls_Manager::REPEATER,
				'default'               => [
					[
						'title'       => __( 'Box 1', 'power-pack' ),
						'description' => __( 'Text box description goes here', 'power-pack' ),
					],
					[
						'title'       => __( 'Box 2', 'power-pack' ),
						'description' => __( 'Text box description goes here', 'power-pack' ),
					],
				],
				'fields'                => [
                    [
                        'name'              => 'title',
                        'label'             => __( 'Title', 'power-pack' ),
                        'type'              => Controls_Manager::TEXT,
                        'dynamic'           => [
                            'active'   => true,
                        ],
                        'default'           => __( 'Title', 'power-pack' ),
                    ],
                    [
                        'name'              => 'description',
                        'label'             => __( 'Description', 'power-pack' ),
                        'type'              => Controls_Manager::WYSIWYG,
                        'dynamic'           => [
                            'active'   => true,
                        ],
                        'default'           => '',
                    ],
				],
				'title_field'           => '{{{ title }}}',
                'condition'             => [
                    'content_type'  => 'custom',
                ],
			]
		);

        $this->end_controls_section();

        /**
         * Content Tab: Toggle Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_button_settings',
            [
                'label'                 => __( 'Toggle Button', 'power-pack' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'                 => __( 'Button Text', 'power-pack' ),
                'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => __( 'Click Here', 'power-pack' ),
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label'                 => __( 'Button Icon', 'power-pack' ),
                'type'                  => Controls_Manager::ICON,
                'default'               => '',
            ]
        );
        
        $this->add_control(
            'button_icon_position',
            [
                'label'                 => __( 'Icon Position', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'before',
                'options'               => [
                    'before'    => __( 'Before', 'power-pack' ),
                    'after'     => __( 'After', 'power-pack' ),
                ],
                'prefix_class'          => 'pp-offcanvas-icon-',
                'condition'             => [
                    'button_icon!'  => '',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'button_icon_spacing',
            [
                'label'                 => __( 'Icon Spacing', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'      => '5',
                    'unit'      => 'px',
                ],
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 50,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}}.pp-offcanvas-icon-before .pp-offcanvas-toggle-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.pp-offcanvas-icon-after .pp-offcanvas-toggle-icon' => 'margin-left: {{SIZE}}{{UNIT}}',
                ],
				'condition'             => [
                    'button_icon!'  => '',
				],
            ]
        );
        
        $this->end_controls_section();

        /**
         * Content Tab: Settings
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_settings',
            [
                'label'                 => __( 'Settings', 'power-pack' ),
            ]
        );

		$this->add_control(
			'content_transition',
			[
				'label'                 => __( 'Content Transition', 'power-pack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'slide',
				'options'               => [
					'slide'        			=> __( 'Slide', 'power-pack' ),
					'reveal'       			=> __( 'Reveal', 'power-pack' ),
					'push'         			=> __( 'Push', 'power-pack' ),
					'slide-along'  	        => __( 'Slide Along', 'power-pack' ),
				],
				'frontend_available'    => true,
				'separator'             => 'before',
			]
		);
        
        $this->add_control(
            'close_button',
            [
                'label'             => __( 'Show Close Button', 'power-pack' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'power-pack' ),
                'label_off'         => __( 'No', 'power-pack' ),
                'return_value'      => 'yes',
                'separator'         => 'before',
            ]
        );
        
        $this->add_control(
            'esc_close',
            [
                'label'             => __( 'Esc to Close', 'power-pack' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'power-pack' ),
                'label_off'         => __( 'No', 'power-pack' ),
                'return_value'      => 'yes',
            ]
		);
		
		$this->add_control(
            'body_click_close',
            [
                'label'             => __( 'Click anywhere to Close', 'power-pack' ),
                'type'              => Controls_Manager::SWITCHER,
                'default'           => 'yes',
                'label_on'          => __( 'Yes', 'power-pack' ),
                'label_off'         => __( 'No', 'power-pack' ),
                'return_value'      => 'yes',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/
        
        /**
         * Style Tab: Offcanvas Bar
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_offcanvas_bar_style',
            [
                'label'                 => __( 'Offcanvas Bar', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'offcanvas_bar_bg',
                'label'                 => __( 'Background', 'power-pack' ),
                'types'                 => [ 'classic', 'gradient' ],
                'selector'              => '.pp-offcanvas-content-{{ID}}',
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'offcanvas_bar_border',
				'label'                 => __( 'Border', 'power-pack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '.pp-offcanvas-content-{{ID}}',
			]
		);

		$this->add_control(
			'offcanvas_bar_border_radius',
			[
				'label'                 => __( 'Border Radius', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'.pp-offcanvas-content-{{ID}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'offcanvas_bar_padding',
			[
				'label'                 => __( 'Padding', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'.pp-offcanvas-content-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'offcanvas_bar_box_shadow',
				'selector'              => '.pp-offcanvas-content-{{ID}}',
				'separator'             => 'before',
			]
		);

        $this->end_controls_section();
        
        /**
         * Style Tab: Title
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_title_style',
            [
                'label'                 => __( 'Title', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
			'title_align',
			[
				'label'                 => __( 'Alignment', 'power-pack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'power-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'power-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'power-pack' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'               => '',
				'selectors'             => [
					'.pp-offcanvas-content-{{ID}} .pp-popup-header .pp-popup-title' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'title_bg',
            [
                'label'                 => __( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '.pp-offcanvas-content-{{ID}} .pp-popup-header .pp-popup-title' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'                 => __( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '.pp-offcanvas-content-{{ID}} .pp-popup-header .pp-popup-title' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'title_border',
				'label'                 => __( 'Border', 'power-pack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '.pp-offcanvas-content-{{ID}} .pp-popup-header .pp-popup-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'                 => __( 'Padding', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'.pp-offcanvas-content-{{ID}} .pp-popup-header .pp-popup-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'title_typography',
                'label'                 => __( 'Typography', 'power-pack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '.pp-offcanvas-content-{{ID}} .pp-popup-header .pp-popup-title',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Content
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_popup_content_style',
            [
                'label'                 => __( 'Content', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
			'content_align',
			[
				'label'                 => __( 'Alignment', 'power-pack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => __( 'Left', 'power-pack' ),
						'icon'  => 'fa fa-align-left',
					],
					'center'    => [
						'title' => __( 'Center', 'power-pack' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'     => [
						'title' => __( 'Right', 'power-pack' ),
						'icon'  => 'fa fa-align-right',
					],
					'justify'   => [
						'title' => __( 'Justified', 'power-pack' ),
						'icon'  => 'fa fa-align-justify',
					],
				],
				'default'               => '',
				'selectors'             => [
					'.pp-offcanvas-content-{{ID}} .pp-popup-content'   => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->add_control(
            'content_text_color',
            [
                'label'                 => __( 'Text Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '.pp-offcanvas-content-{{ID}} .pp-popup-content' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'content_typography',
                'label'                 => __( 'Typography', 'power-pack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '.pp-offcanvas-content-{{ID}} .pp-popup-content',
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Icon
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_icon_style',
            [
                'label'                 => __( 'Icon', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'trigger'       => 'on-click',
					'trigger_type!' => 'button',
				],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'                 => __( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-trigger-icon' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'trigger'       => 'on-click',
					'trigger_type'  => 'icon',
				],
            ]
        );
        
        $this->add_responsive_control(
            'icon_size',
            [
                'label'                 => __( 'Size', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'      => '28',
                    'unit'      => 'px',
                ],
                'range'                 => [
                    'px'        => [
                        'min'   => 10,
                        'max'   => 80,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-trigger-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
				'condition'             => [
					'trigger'       => 'on-click',
					'trigger_type'  => 'icon',
				],
            ]
        );
        
        $this->add_responsive_control(
            'icon_image_width',
            [
                'label'                 => __( 'Width', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px'        => [
                        'min'   => 10,
                        'max'   => 1200,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-trigger-image' => 'width: {{SIZE}}{{UNIT}}',
                ],
				'condition'             => [
					'trigger'       => 'on-click',
					'trigger_type'  => 'image',
				],
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Toggle Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_toggle_button_style',
            [
                'label'                 => __( 'Toggle Button', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
			'button_align',
			[
				'label'                 => __( 'Alignment', 'power-pack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => 'left',
				'options'               => [
					'left'          => [
						'title'     => __( 'Left', 'power-pack' ),
						'icon'      => 'eicon-h-align-left',
					],
					'center'        => [
						'title'     => __( 'Center', 'power-pack' ),
						'icon'      => 'eicon-h-align-center',
					],
					'right'         => [
						'title'     => __( 'Right', 'power-pack' ),
						'icon'      => 'eicon-h-align-right',
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-offcanvas-toggle-wrap'   => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'                 => __( 'Size', 'power-pack' ),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'md',
				'options'               => [
					'xs' => __( 'Extra Small', 'power-pack' ),
					'sm' => __( 'Small', 'power-pack' ),
					'md' => __( 'Medium', 'power-pack' ),
					'lg' => __( 'Large', 'power-pack' ),
					'xl' => __( 'Extra Large', 'power-pack' ),
				],
			]
		);

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label'                 => __( 'Normal', 'power-pack' ),
            ]
        );

        $this->add_control(
            'button_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-offcanvas-toggle' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_normal',
            [
                'label'                 => __( 'Text Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-offcanvas-toggle' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_normal',
				'label'                 => __( 'Border', 'power-pack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .pp-offcanvas-toggle',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => __( 'Border Radius', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-offcanvas-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'button_typography',
                'label'                 => __( 'Typography', 'power-pack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '{{WRAPPER}} .pp-offcanvas-toggle',
            ]
        );

		$this->add_responsive_control(
			'button_padding',
			[
				'label'                 => __( 'Padding', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .pp-offcanvas-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .pp-offcanvas-toggle',
			]
		);
        
        $this->add_control(
            'info_box_button_icon_heading',
            [
                'label'                 => __( 'Button Icon', 'power-pack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

		$this->add_responsive_control(
			'button_icon_margin',
			[
				'label'                 => __( 'Margin', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'placeholder'           => [
					'top'      => '',
					'right'    => '',
					'bottom'   => '',
					'left'     => '',
				],
				'selectors'             => [
					'{{WRAPPER}} .pp-offcanvas-toggle .pp-button-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label'                 => __( 'Hover', 'power-pack' ),
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-offcanvas-toggle:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label'                 => __( 'Text Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-offcanvas-toggle:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-offcanvas-toggle:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

		$this->add_control(
			'button_animation',
			[
				'label'                 => __( 'Animation', 'power-pack' ),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .pp-offcanvas-toggle:hover',
			]
		);

		$this->end_controls_tab();

        $this->end_controls_tabs();
        
		$this->end_controls_section();
		
		/**
         * Style Tab: Close Button
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_close_button_style',
            [
                'label'                 => __( 'Close Button', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
		);

		$this->add_control(
            'close_button_text_color',
            [
                'label'                 => __( 'Text Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .pp-offcanvas-close' => 'color: {{VALUE}}',
                ],
            ]
        );
		
		$this->end_controls_section();

    }

    /**
	 * Render offcanvas content widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $settings_attr = array(
            'content_id'		=> esc_attr( $this->get_id() ),
			'transition'		=> esc_attr( $settings['content_transition'] ),
			'esc_close'			=> esc_attr( $settings['esc_close'] ),
			'body_click_close'	=> esc_attr( $settings['body_click_close'] )
        );

        $this->add_render_attribute( 'content-wrap', 'class', 'pp-offcanvas-content-wrap');

        $this->add_render_attribute( 'content-wrap', 'data-settings', htmlspecialchars( json_encode( $settings_attr ) ) );

        $this->add_render_attribute( 'content', 'class',
            [
                'pp-offcanvas-content',
				'pp-offcanvas-content-' . $this->get_id(),
				'pp-offcanvas-' . $settings_attr['transition'],
				'elementor-element-' . $this->get_id(),
            ]
        );
        
        $this->add_render_attribute( 'toggle-button', 'class', [
                'pp-offcanvas-toggle',
                'pp-offcanvas-toggle-' . esc_attr( $this->get_id() ),
                'elementor-button',
                'elementor-size-' . $settings['button_size'],
            ]
        );

        if ( $settings['button_animation'] ) {
            $this->add_render_attribute( 'toggle-button', 'class', 'elementor-animation-' . $settings['button_animation'] );
        }
        ?>
        
        <div <?php echo $this->get_render_attribute_string( 'content-wrap' ); ?>>

            <?php if ( $settings['button_text'] != '' || $settings['button_icon'] != '' ) { ?>
                <div class="pp-offcanvas-toggle-wrap">
                    <div <?php echo $this->get_render_attribute_string( 'toggle-button' ); ?>>
                        <?php if ( ! empty( $settings['button_icon'] ) ) { ?>
                            <span class="pp-offcanvas-toggle-icon <?php echo esc_attr( $settings['button_icon'] ); ?>" aria-hidden="true"></span>
                        <?php } ?>
                        <span class="pp-offcanvas-toggle-text">
                            <?php echo $settings['button_text']; ?>
                        </span>
                    </div>
                </div>
            <?php } ?>
            
			<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
				<div class="pp-offcanvas-header">
					<div class="pp-offcanvas-close" role="button" style="color: <?php echo $settings['close_button_text_color']; ?>">×</div>
				</div>
				<div class="pp-offcanvas-body">
                <?php
                    if ( $settings['content_type'] == 'sidebar' ) {
                        $this->render_sidebar();
                    } elseif ( $settings['content_type'] == 'custom' ) {
                        $this->render_custom_content();
                    } elseif ( $settings['content_type'] == 'template' ) {
                        $this->render_saved_template();
                    }
				?>
				</div>
            </div>
        </div>
        <?php
    }
    
    /**
	 * Render sidebar content output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_sidebar() {
        $settings = $this->get_settings_for_display();
        
        $sidebar = $settings['sidebar'];

        if ( empty( $sidebar ) ) {
            return;
        }

        dynamic_sidebar( $sidebar );
    }
    
    /**
	 * Render saved template output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_custom_content() {
        $settings = $this->get_settings_for_display();
        
        foreach ( $settings['custom_content'] as $index => $item ) :
            ?>
            <div class="pp-offcanvas-custom-widget">
                <h3 class="pp-offcanvas-widget-title">
                    <?php echo $item['title']; ?>
                </h3>
                <div class="pp-offcanvas-widget-content">
                    <?php echo $item['description']; ?>
                </div>
            </div>
            <?php
        endforeach;
    }
    
    /**
	 * Render saved template output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_saved_template() {
        $settings = $this->get_settings_for_display();
        
        if ( !empty( $settings['templates'] ) ) {
            $pp_template_id = $settings['templates'];
            $pp_frontend = new Frontend;

            echo $pp_frontend->get_builder_content( $pp_template_id, true );
        }
    }

    /**
	 * Render offcanvas content widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
    protected function _content_template() {}

}

Plugin::instance()->widgets_manager->register_widget_type( new PP_Offcanvas_Content_Widget() );