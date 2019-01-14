<?php
namespace PowerpackElements\Modules\OffcanvasContent\Widgets;

use PowerpackElements\Base\Powerpack_Widget;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Offcanvas Content Widget
 */
class Offcanvas_Content extends Powerpack_Widget {
    
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
        return 'ppicon-offcanvas-content power-pack-admin-icon';
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
            'powerpack-frontend'
        ];
    }
    
    /**
	 * Retrieve the list of styles the offcanvas content widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
    public function get_style_depends() {
        return [
            'pp-hamburgers'
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
                    'section'   => __( 'Saved Section', 'power-pack' ),
                    'widget'    => __( 'Saved Widget', 'power-pack' ),
                    'template'  => __( 'Saved Page Template', 'power-pack' ),
                ],
                'default'               => 'custom',
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
            'saved_widget',
            [
                'label'                 => __( 'Choose Widget', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'widget' ),
				'default'               => '-1',
				'condition'             => [
					'content_type'    => 'widget',
				],
            ]
        );

        $this->add_control(
            'saved_section',
            [
                'label'                 => __( 'Choose Section', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'section' ),
				'default'               => '-1',
				'condition'             => [
					'content_type'    => 'section',
				],
            ]
        );

        $this->add_control(
            'templates',
            [
                'label'                 => __( 'Choose Template', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => $this->get_page_template_options( 'page' ),
				'default'               => '-1',
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
         * Content Tab: Toggle
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_button_settings',
            [
                'label'                 => __( 'Toggle', 'power-pack' ),
            ]
        );
        
        $this->add_control(
            'toggle_source',
            [
                'label'                 => __( 'Toggle Source', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'button',
                'options'               => [
                    'button'    => __( 'Button', 'power-pack' ),
                    'burger'    => __( 'Burger Icon', 'power-pack' ),
                ],
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
                'condition'             => [
                    'toggle_source'     => 'button',
                ],
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label'                 => __( 'Button Icon', 'power-pack' ),
                'type'                  => Controls_Manager::ICON,
                'default'               => '',
                'condition'             => [
                    'toggle_source'     => 'button',
                ],
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
                    'toggle_source'     => 'button',
                    'button_icon!'      => '',
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
                    'toggle_source'     => 'button',
                    'button_icon!'      => '',
				],
            ]
        );

        $this->add_control(
            'toggle_effect',
            [
                'label'                 => __( 'Animation', 'power-pack' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'arrow',
                'options'               => [
                    '' 				=> __( 'None', 'power-pack' ),
                    'arrow' 		=> __( 'Arrow Left', 'power-pack' ),
                    'arrow-r' 		=> __( 'Arrow Right', 'power-pack' ),
                    'arrowalt' 		=> __( 'Arrow Alt Left', 'power-pack' ),
                    'arrowalt-r' 	=> __( 'Arrow Alt Right', 'power-pack' ),
                    'arrowturn' 	=> __( 'Arrow Turn Left', 'power-pack' ),
                    'arrowturn-r' 	=> __( 'Arrow Turn Right', 'power-pack' ),
                    'boring' 		=> __( 'Boring', 'power-pack' ),
                    'collapse' 		=> __( 'Collapse Left', 'power-pack' ),
                    'collapse-r' 	=> __( 'Collapse Right', 'power-pack' ),
                    'elastic' 		=> __( 'Elastic Left', 'power-pack' ),
                    'elastic-r' 	=> __( 'Elastic Right', 'power-pack' ),
                    'emphatic' 		=> __( 'Emphatic Left', 'power-pack' ),
                    'emphatic-r' 	=> __( 'Emphatic Right', 'power-pack' ),
                    'minus' 		=> __( 'Minus', 'power-pack' ),
                    'slider' 		=> __( 'Slider Left', 'power-pack' ),
                    'slider-r' 		=> __( 'Slider Right', 'power-pack' ),
                    'spin' 			=> __( 'Spin Left', 'power-pack' ),
                    'spin-r' 		=> __( 'Spin Right', 'power-pack' ),
                    'spring' 		=> __( 'Spring Left', 'power-pack' ),
                    'spring-r' 		=> __( 'Spring Right', 'power-pack' ),
                    'squeeze' 		=> __( 'Squeeze', 'power-pack' ),
                    'stand' 		=> __( 'Stand Left', 'power-pack' ),
                    'stand-r' 		=> __( 'Stand Right', 'power-pack' ),
                    'vortex' 		=> __( 'Vortex Left', 'power-pack' ),
                    'vortex-r' 		=> __( 'Vortex Right', 'power-pack' ),
                    '3dx'           => __( '3DX', 'power-pack' ),
                    '3dy'           => __( '3DY', 'power-pack' ),
                    '3dxy'          => __( '3DXY', 'power-pack' ),
                ],
                'condition'             => [
                    'toggle_source'     => 'burger',
                ],
            ]
        );

        $this->add_control(
            'burger_label',
            [
                'label'                 => __( 'Label', 'power-pack' ),
                'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
                'default'               => __( 'Menu', 'power-pack' ),
                'condition'             => [
                    'toggle_source'     => 'burger',
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
			'direction',
			[
				'label'                 => __( 'Direction', 'power-pack' ),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'toggle'                => false,
				'default'               => 'left',
				'options'               => [
					'left'          => [
						'title'     => __( 'Left', 'power-pack' ),
						'icon'      => 'eicon-h-align-left',
					],
					'right'         => [
						'title'     => __( 'Right', 'power-pack' ),
						'icon'      => 'eicon-h-align-right',
					],
					'top'         => [
						'title'     => __( 'Top', 'power-pack' ),
						'icon'      => 'eicon-v-align-top',
					],
					'bottom'         => [
						'title'     => __( 'Bottom', 'power-pack' ),
						'icon'      => 'eicon-v-align-bottom',
					],
				],
				'frontend_available'    => true,
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
					'.pp-offcanvas-content-{{ID}} .pp-offcanvas-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
         * Style Tab: Content
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_popup_content_style',
            [
                'label'                 => __( 'Content', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
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
					'.pp-offcanvas-content-{{ID}} .pp-offcanvas-body'   => 'text-align: {{VALUE}};',
				],
			]
		);
        
        $this->add_control(
            'widget_heading',
            [
                'label'                 => __( 'Box', 'power-pack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );

        $this->add_control(
            'widgets_bg_color',
            [
                'label'                 => __( 'Background Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '.pp-offcanvas-content-{{ID}} .pp-offcanvas-custom-widget, .pp-offcanvas-content-{{ID}} .widget' => 'background-color: {{VALUE}}',
                ],
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'widgets_border',
				'label'                 => __( 'Border', 'power-pack' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '.pp-offcanvas-content-{{ID}} .pp-offcanvas-custom-widget, .pp-offcanvas-content-{{ID}} .widget',
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
			]
		);

		$this->add_control(
			'widgets_border_radius',
			[
				'label'                 => __( 'Border Radius', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'.pp-offcanvas-content-{{ID}} .pp-offcanvas-custom-widget, .pp-offcanvas-content-{{ID}} .widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
			]
		);
        
        $this->add_responsive_control(
            'widgets_bottom_spacing',
            [
                'label'                 => __( 'Bottom Spacing', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'      => '20',
                    'unit'      => 'px',
                ],
                'range'                 => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '.pp-offcanvas-content-{{ID}} .pp-offcanvas-custom-widget, .pp-offcanvas-content-{{ID}} .widget' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );

		$this->add_responsive_control(
			'widgets_padding',
			[
				'label'                 => __( 'Padding', 'power-pack' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'.pp-offcanvas-content-{{ID}} .pp-offcanvas-custom-widget, .pp-offcanvas-content-{{ID}} .widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
			]
		);
        
        $this->add_control(
            'text_heading',
            [
                'label'                 => __( 'Text', 'power-pack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
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
                    '.pp-offcanvas-content-{{ID}} .pp-offcanvas-body, .pp-offcanvas-content-{{ID}} .pp-offcanvas-body *:not(.fa):not(.eicon)' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'text_typography',
                'label'                 => __( 'Typography', 'power-pack' ),
                'selector'              => '.pp-offcanvas-content-{{ID}} .pp-offcanvas-body, .pp-offcanvas-content-{{ID}} .pp-offcanvas-body *:not(.fa):not(.eicon)',
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );
        
        $this->add_control(
            'links_heading',
            [
                'label'                 => __( 'Links', 'power-pack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );

        $this->start_controls_tabs( 'tabs_links_style' );

        $this->start_controls_tab(
            'tab_links_normal',
            [
                'label'                 => __( 'Normal', 'power-pack' ),
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );

        $this->add_control(
            'content_links_color',
            [
                'label'                 => __( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '.pp-offcanvas-content-{{ID}} .pp-offcanvas-body a' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'links_typography',
                'label'                 => __( 'Typography', 'power-pack' ),
                'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
                'selector'              => '.pp-offcanvas-content-{{ID}} .pp-offcanvas-body a',
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_links_hover',
            [
                'label'                 => __( 'Hover', 'power-pack' ),
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );

        $this->add_control(
            'content_links_color_hover',
            [
                'label'                 => __( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '.pp-offcanvas-content-{{ID}} .pp-offcanvas-body a:hover' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'content_type'      => [ 'sidebar', 'custom' ],
				],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
         * Style Tab: Toggle
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_toggle_button_style',
            [
                'label'                 => __( 'Toggle', 'power-pack' ),
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
                'condition'             => [
                    'toggle_source'     => 'button',
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
                    '{{WRAPPER}} .pp-hamburger-inner, {{WRAPPER}} .pp-hamburger-inner::before, {{WRAPPER}} .pp-hamburger-inner::after' => 'background-color: {{VALUE}}',
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
            'toggle_icon_heading',
            [
                'label'                 => __( 'Icon', 'power-pack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
				'condition'             => [
					'toggle_source'     => 'burger',
				],
            ]
        );
        
        $this->add_responsive_control(
            'toggle_icon_size',
            [
                'label'                 => __( 'Size', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    'size'      => 1,
                ],
                'range'                 => [
                    'px'        => [
                        'min'   => 0.1,
                        'max'   => 3,
                        'step'  => 0.01,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .pp-hamburger-box' => 'font-size: {{SIZE}}em',
                ],
				'condition'             => [
					'toggle_source'     => 'burger',
				],
            ]
        );
        
        $this->add_control(
            'toggle_label_heading',
            [
                'label'                 => __( 'Label', 'power-pack' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
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
				'condition'             => [
					'close_button' => 'yes',
				],
            ]
		);

        $this->add_control(
            'close_button_icon',
            [
                'label'                 => __( 'Button Icon', 'power-pack' ),
                'type'                  => Controls_Manager::ICON,
                'default'               => 'fa fa-close',
				'condition'             => [
					'close_button' => 'yes',
				],
            ]
        );

		$this->add_control(
            'close_button_text_color',
            [
                'label'                 => __( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '.pp-offcanvas-close-{{ID}}' => 'color: {{VALUE}}',
                ],
				'condition'             => [
					'close_button' => 'yes',
				],
            ]
        );
        
        $this->add_responsive_control(
            'close_button_size',
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
                    '.pp-offcanvas-content-{{ID}} .pp-offcanvas-close-{{ID}}' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
				'condition'             => [
					'close_button' => 'yes',
				],
            ]
        );
		
		$this->end_controls_section();
		
		/**
         * Style Tab: Overlay
         * -------------------------------------------------
         */
        $this->start_controls_section(
            'section_overlay_style',
            [
                'label'                 => __( 'Overlay', 'power-pack' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
		);

		$this->add_control(
            'overlay_bg_color',
            [
                'label'                 => __( 'Color', 'power-pack' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '.pp-offcanvas-content-{{ID}}-open .pp-offcanvas-container:after' => 'background: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'overlay_opacity',
            [
                'label'                 => __( 'Opacity', 'power-pack' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => 0.01,
                    ],
                ],
				'selectors'             => [
					'.pp-offcanvas-content-{{ID}}-open .pp-offcanvas-container:after' => 'opacity: {{SIZE}};',
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
			'direction'		    => esc_attr( $settings['direction'] ),
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

        $this->add_render_attribute( 'content', 'class', 'pp-offcanvas-content-' . $settings['direction'] );
        
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
        
        $this->add_render_attribute( 'hamburger', 'class', [
                'pp-offcanvas-toggle',
                'pp-offcanvas-toggle-' . esc_attr( $this->get_id() ),
                'pp-button',
                'pp-hamburger',
                'pp-hamburger--' . $settings['toggle_effect'],
            ]
        );
        ?>
        
        <div <?php echo $this->get_render_attribute_string( 'content-wrap' ); ?>>

            <?php
                // Toggle
                $this->render_toggle();
            ?>
            
			<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
				<?php echo $this->render_close_button(); ?>
				<div class="pp-offcanvas-body">
                <?php
                    if ( $settings['content_type'] == 'sidebar' ) {

                        $this->render_sidebar();

                    } elseif ( $settings['content_type'] == 'custom' ) {

                        $this->render_custom_content();

                    } elseif ( $settings['content_type'] == 'section' && !empty( $settings['saved_section'] ) ) {

                        echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['saved_section'] );

                    } elseif ( $settings['content_type'] == 'template' && !empty( $settings['templates'] ) ) {
                        
                        echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['templates'] );
                        
                    } elseif ( $settings['content_type'] == 'widget' && !empty( $settings['saved_widget'] ) ) {

                        echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['saved_widget'] );

                    }
				?>
				</div>
            </div>
        </div>
        <?php
    }
    
    /**
	 * Render toggle output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_toggle() {
        $settings = $this->get_settings_for_display();
        
        if ( $settings['toggle_source'] == 'button' ) {
            if ( $settings['button_text'] != '' || $settings['button_icon'] != '' ) { ?>
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
            <?php }
        } elseif ( $settings['toggle_source'] == 'burger' ) { ?>
            <div class="pp-offcanvas-toggle-wrap">
                <div <?php echo $this->get_render_attribute_string( 'hamburger' ); ?>>
                    <span class="pp-hamburger-box">
                        <span class="pp-hamburger-inner"></span>
                    </span>
                    <?php if ( $settings['burger_label'] ) { ?>
                        <span class="pp-hamburger-label">
                            <?php echo $settings['burger_label']; ?>
                        </span>
                    <?php } ?>
                </div>
            </div>
        <?php }
    }
    
    /**
	 * Render sidebar content output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_close_button() {
        $settings = $this->get_settings_for_display();
        
        if ( $settings['close_button'] != 'yes' ) {
            return;
        }
        
        $this->add_render_attribute( 'close-button', 'class',
            [
                'pp-offcanvas-close',
				'pp-offcanvas-close-' . $this->get_id()
            ]
        );
        
        $this->add_render_attribute( 'close-button', 'role', 'button' );
        ?>
        <div class="pp-offcanvas-header">
            <div <?php echo $this->get_render_attribute_string( 'close-button' ); ?>>
                <?php if ( $settings['close_button_icon'] != '' ) { ?>
                    <span class="<?php echo $settings['close_button_icon']; ?>"></span>
                <?php } else { ?>
                    <span class="fa fa-close"></span>
                <?php } ?>
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
        
        if ( $settings['content_type'] == 'section' && !empty( $settings['saved_section'] ) ) {
            //$pp_template_id = $settings['templates'];
            
            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['saved_section'] );
            
            //echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $pp_template_id );
        } elseif ( $settings['content_type'] == 'template' && !empty( $settings['templates'] ) ) {

            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['templates'] );

        } elseif ( $settings['content_type'] == 'widget' && !empty( $settings['saved_widget'] ) ) {

            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $settings['saved_widget'] );

        }
    }

	/**
	 *  Get Saved Widgets
	 *
	 *  @param string $type Type.
	 *  
	 *  @return string
	 */
	public function get_page_template_options( $type = '' ) {

		$page_templates = pp_get_page_templates( $type );

		$options[-1]   = __( 'Select', 'power-pack' );

		if ( count( $page_templates ) ) {
			foreach ( $page_templates as $id => $name ) {
				$options[ $id ] = $name;
			}
		} else {
			$options['no_template'] = __( 'No saved templates found!', 'power-pack' );
		}

		return $options;
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