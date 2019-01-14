<?php
namespace Elementor;

use Elementor\Core\Responsive\Responsive;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EAEL Facebook Feed Widget
 */
class Widget_Eael_Facebook_Feed extends Widget_Base {

    /**
	 * Retrieve Facebook Feed widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'eael-facebook-feed';
	}

	/**
	 * Retrieve Facebook Feed widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'EA Facebook Feed', 'essential-addons-elementor' );
	}

	/**
	 * Retrieve Facebook Feed widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-facebook-official';
	}

	/**
	 * Retrieve the list of categories the Facebook Feed belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'essential-addons-elementor' ];
	}

	/**
	 * Retrieve the list of scripts the Facebook Feed widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [
			'essential_addons_elementor-codebird-js',
			'essential_addons_elementor-doT-js',
			'essential_addons_elementor-moment-js',
			'essential_addons_elementor-socialfeed-js',
			'essential_addons_elementor-masonry-js'
		];
	}

	/**
	 * If any changes need reload.
	 * 
	 * @return bool true
	 */
	protected function is_reload_required_for_preview() {
		return true;
	}

	protected function _register_controls() {

		/**
		 * Section: Credentials
		 * -------------------------------
		 */
		$this->start_controls_section(
			'credentials_section',
			[
				'label'	=> __( 'Credentials', 'essential-addons-elementor' )
			]
		);

		$this->add_control(
			'eael_facebook_feed_title_heading',
			[
				'label'     => esc_html__( 'Access Token Of Your Facebook Page', 'essential-addons-elementor' ),
				'type'      => Controls_Manager::HEADING
			]
		);

		$this->add_control(
			'access_token',
			[
				'label'       => esc_html__( 'Access Token', 'essential-addons-elementor' ),
				'default'     => 'EAAB9sCwO9XwBACyjE37AO7e799ZAJzFTkKHZAVQiVy9yVuztopLthx3yzOZAZBbViNrZATqyCZAWNcJTcjk5DfIsHZC2GixaXBCNGBhyWJ68IFQjYunZAv4FcobbVGUUJXstiXhR7MsC3wtzet5dlHkfmGzQSedZCQiq3HaIe1xUXV6o9VZAY8FcZBlwFUzlYcyaL5lZCbP89aDQ4dU3A50A11qs',   //TODO: change access token by wpdeveloper access token,
				'description' => 'Click <a href="https://developers.facebook.com/tools/explorer/" target="_blank">Here</a> to know how to get your page access token',// TODO: Make our own documentation video about how to get access token.
				'type'        => Controls_Manager::TEXT,
				'separator'   => 'after'
			]
		);

		$this->add_control(
			'account_id',
			[
				'label'       => esc_html__( 'Page Slug', 'essential-addons-elementor' ),
				'default'     => '!WPdeveloperNet',//TODO: change account name when token will be changed by wpdeveloper access token,
				'type'        => Controls_Manager::TEXT,
				'description' => 'Account ID is prefixed by @, Page Slug is prefixed by !, click <a target="_blank" href="https://findmyfbid.com/"> here</a> to get account ID',
				'label_block' => true,
			]
		);

		$this->end_controls_section(); # End of Credentials Section


		/**
		 * Section: Layout
		 * -------------------------------
		 */
		$this->start_controls_section(
  			'eael_section_layout_settings',
  			[
  				'label' => esc_html__( 'Layout Settings', 'essential-addons-elementor' )
  			]
  		);

		$this->add_control(
			'facebook_feed_layout_style',
			[
				'label'   => esc_html__( 'Content Layout', 'essential-addons-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'list',
				'options' => [
					'list'    => esc_html__( 'List', 'essential-addons-elementor' ),
					'masonry' => esc_html__( 'Masonry', 'essential-addons-elementor' ),
				],
			]
		);

		$this->add_control(
            'feed_column_number',
            [
                'label'   => __( 'Column Grid', 'essential-addons-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'two'   => __( '2 Columns', 'essential-addons-elementor' ),
                    'three' => __( '3 Columns', 'essential-addons-elementor' ),
                    'four'  => __( '4 Columns', 'essential-addons-elementor' ),
                    'five'  => __( '5 Columns', 'essential-addons-elementor' ),
                    'six'   => __( '6 Columns', 'essential-addons-elementor' )
                ],
                'default'      => 'two',
                'prefix_class' => 'eael-social-feed-masonry-',
                'condition'    => [
                	'eael_facebook_feed_type' => 'masonry'
                ],
            ]
		);
		
		// Note: New Control
        $this->add_control(
			'direction',
            [
                'label'         => esc_html__( 'Direction', 'essential-addons-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'ltr'    => [
                        'title' => __( 'Left to Right', 'essential-addons-elementor' ),
                        'icon'  => 'fa fa-chevron-circle-right',
                    ],
                    'rtl'   => [
                        'title' => __( 'Right to Left', 'essential-addons-elementor' ),
                        'icon'  => 'fa fa-chevron-circle-left',
                    ],
                ],
                'default'       => 'ltr',
            ]
		);
		
		// Note: New Control
		$this->add_responsive_control(
			'align',
            [
                'label'         => esc_html__( 'Content Alignment', 'essential-addons-elementor' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left'          => [
                        'title' => __( 'Left', 'essential-addons-elementor' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'        => [
                        'title' => __( 'Center', 'essential-addons-elementor' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'          => [
                        'title' => __( 'Right', 'essential-addons-elementor' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify'       => [
                        'title' => esc_html__( 'Justify', 'essential-addons-elementor' ),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-social-feed-text, {{WRAPPER}} .eael-read-button' => 'text-align: {{VALUE}}',
                ],
                'default'       => 'left',
            ]
		);
		
		$this->add_control(
			'post_limit',
			[
				'label'       => esc_html__( 'Post Limit', 'essential-addons-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'default'     => 5
			]
		);

		$this->add_responsive_control(
			'column_spacing',
			[
				'label' => esc_html__( 'Column spacing', 'essential-addons-elementor' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .eael-social-feed-element' => 'padding: {{SIZE}}px;',
				],
			]
		);

  		$this->end_controls_section(); # end of Layout section.

		/**
		 * Section: Card Settings
		 * -------------------------------
		 */
  		$this->start_controls_section(
  			'feed_card_settings',
  			[
  				'label' => esc_html__( 'Card Settings', 'essential-addons-elementor' ),
  			]
		);

		$this->add_control(
			'content_length',
			[
				'label'       => esc_html__( 'Content Length', 'essential-addons-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => '400'
			]
		);
		  
		$this->add_control(
			'feed_media',
			[
				'label'        => esc_html__( 'Show Media', 'essential-addons-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'essential-addons-elementor' ),
				'label_off'    => __( 'No', 'essential-addons-elementor' ),
				'default'      => 'true',
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'show_avatar', 
            [
                'label'             => esc_html__('Show Avatar','essential-addons-elementor'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'block' => esc_html__('Show', 'essential-addons-elementor'),
                    'none'  => esc_html__('Hide', 'essential-addons-elementor'),
                ],
                'default'           => 'block',
                'selectors'         => [
                    '{{WRAPPER}} .eael-author-img'   => 'display: {{VALUE}}'
                ]
            ]
		);
		
		$this->add_control(
            'feed_avatar_style',
            [
                'label'   => __( 'Avatar Style', 'essential-addons-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'circle' => 'Circle',
                    'square' => 'Square'
                ],
                'default'      => 'circle',
                'prefix_class' => 'eael-social-feed-avatar-',
                'condition'    => [
                	'show_avatar' => 'block'
                ],
            ]
		);
        
        $this->add_control('show_date', 
            [
                'label'             => esc_html__('Show Date','essential-addons-elementor'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'block' => esc_html__('Show', 'essential-addons-elementor'),
                    'none'  => esc_html__('Hide', 'essential-addons-elementor'),
                ],
                'default'           => 'block',
                'selectors'         => [
                    '{{WRAPPER}} .eael-social-date'   => 'display: {{VALUE}}'
                ]
            ]
        );

        $this->add_control('read', 
            [
                'label'             => esc_html__('Show Read More Button','essential-addons-elementor'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'block' => esc_html__('Show', 'essential-addons-elementor'),
                    'none'  => esc_html__('Hide', 'essential-addons-elementor'),
                ],
                'default'           => 'block',
                'selectors'         => [
                    '{{WRAPPER}} .eael-read-button'   => 'display: {{VALUE}}'
                ]
            ]
        );
        
        $this->add_control('show_icon',
            [
                'label'             => esc_html__('Show Facebook Icon','essential-addons-elementor'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'inline-block' => esc_html__('Show', 'essential-addons-elementor'),
                    'none'  => esc_html__('Hide', 'essential-addons-elementor'),
                ],
                'default'           => 'inline-block',
                'selectors'         => [
                    '{{WRAPPER}} .eael-social-icon'   => 'display: {{VALUE}}'
                ]
            ]
        );

		$this->end_controls_section(); # end of Card Settings section.
		
  		/**
		 *
		 * Tab Style: Section => Post Box
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'section_feed_box_style',
			[
				'label' => esc_html__( 'Post Box', 'essential-addons-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs( 'post_box' );
			$this->start_controls_tab(
				'post_box_normal',
				[
					'label' => esc_html__('Normal', 'essential-addons-elementor'),
				]
			);

			$this->add_control(
				'post_box_background', 
				[
					'label'     => esc_html__('Background', 'essential-addons-elementor'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eael-social-feed-element' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(), 
				[
					'name'     => 'post_box_border',
					'selector' => '{{WRAPPER}} .eael-social-feed-element',
				]
			);

			$this->add_control('post_box_border_radius',
				[
					'label'      => esc_html__('Border Radius', 'essential-addons-elementor'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => ['px', '%' ,'em'],
					'default'    => [
						'unit' => 'px',
						'size' => 0,
					],
					'selectors'     => [
						'{{WRAPPER}} .eael-social-feed-element' => 'border-radius: {{SIZE}}{{UNIT}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'post_box_shadow',
					'selector' => '{{WRAPPER}} .eael-social-feed-element',
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'post_box_hover',
				[
					'label' => esc_html__('Hover', 'essential-addons-elementor'),
				]
			);

			$this->add_control(
				'post_box_background_hover', 
				[
					'label'     => esc_html__('Background', 'essential-addons-elementor'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eael-social-feed-element:hover' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border:: get_type(),
				[
					'name'     => 'post_box_border_hover',
					'selector' => '{{WRAPPER}} .eael-social-feed-element:hover',
				]
			);

			$this->add_control(
				'post_box_border_radius_hover',
				[
					'label'      => esc_html__('Border Radius', 'essential-addons-elementor'),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => ['px', '%' ,'em'],
					'default'    => [
						'unit' => 'px',
						'size' => 0,
					],
					'selectors'     => [
						'{{WRAPPER}} .eael-social-feed-element:hover' => 'border-radius: {{SIZE}}{{UNIT}};'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'post_box_shadow_hover',
					'selector' => '{{WRAPPER}} .eael-social-feed-element:hover',
				]
			);

			$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'post_box_margin',
            [
                'label'      => esc_html__('Margin', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'separator'  => 'before',
                'selectors'  => [
                    '{{WRAPPER}} .eael-social-feed-element' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'post_box_padding',
            [
				'label'      => esc_html__('Padding', 'essential-addons-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .eael-social-feed-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
		$this->end_controls_section(); # end of Tab Style: Section => Post Box
		

		/**
		 *
		 * Tab Style: Section => Content
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'content_style',
            [
                'label' => esc_html__('Content','essential-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'content_color', 
            [
                'label'  => esc_html__('Color', 'essential-addons-elementor'),
                'type'   => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-social-feed-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'facebook_feed_content_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-social-feed-text',
            ]
        );

        $this->add_responsive_control(
			'facebook_feed_content_margin',
            [
                'label'      => esc_html__('Margin', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-social-feed-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
			'facebook_feed_read_more_heading',
            [
                'label'     => esc_html__('Read More', 'essential-addons-elementor'),
                'type'      => Controls_Manager::HEADING,
                'condition' => [
                    'read' => 'block'
                ],
            ]
        );

        $this->add_control(
			'read_more_color', 
            [
                'label'  => esc_html__('Color', 'essential-addons-elementor'),
                'type'   => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                    ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-read-button' => 'color: {{VALUE}};',
                ],
                'condition'     => [
                    'read' => 'block'
                ],
            ]
        );

        $this->add_control(
			'read_more_color_hover', 
            [
                'label'  => esc_html__('Hover Color', 'essential-addons-elementor'),
                'type'   => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                    ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-read-button:hover' => 'color: {{VALUE}};',
                ],
                'condition'     => [
                    'read' => 'block'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'facebook_feed_read_more_typography',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .eael-read-button',
                'condition' => [
                    'read' => 'block'
                ],
            ]
        );
		$this->end_controls_section(); # end of "Tab Style: Section => Content"
		
		/**
		 *
		 * Tab Style: Section => Avatar
		 * -------------------------------------------
		 */
		$this->start_controls_section(
			'avatar_style',
            [
                'label'     => esc_html__('Avatar','essential-addons-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_avatar' => 'block'
                ]
            ]
        );

        $this->add_responsive_control(
			'avatar_size',
            [
                'label'         => esc_html__('Size', 'essential-addons-elementor'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px',"em", '%'],
                'selectors'     => [
                    '{{WRAPPER}} .eael-social-feed-element .media-object ' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'     => 'avatar_border',
                'selector' => '{{WRAPPER}} .eael-author-img img',
            ]
        );

        $this->add_control(
			'avatar_radius',
            [
                'label'      => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px',"em", '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-author-img img' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'avatar_margin',
            [
                'label'      => esc_html__('Margin', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-author-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section(); # end of "Avatar"

		/**
		 *
		 * Tab Style: Section => Facebook Icon
		 * -------------------------------------------
		 */
        $this->start_controls_section(
			'icon_style',
            [
                'label'     => esc_html__('Facebook Icon','essential-addons-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_icon' => 'inline-block'
                ]
            ]
        );

        $this->add_control(
			'facebook_icon_color', 
            [
                'label'  => esc_html__('Color', 'essential-addons-elementor'),
                'type'   => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-social-icon' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
			'facebook_icon_size',
            [
                'label'      => esc_html__('Size', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px',"em"],
                'selectors'  => [
                    '{{WRAPPER}} .eael-social-icon' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'icon_margin',
            [
                'label'      => esc_html__('Margin', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-social-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_section(); # end of "Facebook Icon"

		/**
		 *
		 * Tab Style: Section => Author
		 * -------------------------------------------
		 */
        $this->start_controls_section(
			'title_style',
            [
                'label' => esc_html__('Author','essential-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'title_color', 
            [
                'label'  => esc_html__('Color', 'essential-addons-elementor'),
                'type'   => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-social-author-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
			'title_hover_color', 
            [
                'label'  => esc_html__('Hover Color', 'essential-addons-elementor'),
                'type'   => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-social-author-title:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-social-author-title a',
            ]
        ); 

        $this->add_responsive_control(
			'title_margin',
            [
                'label'      => esc_html__('Margin', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-social-author-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_section(); # end of "Author"

		/**
		 *
		 * Tab Style: Section => Date
		 * -------------------------------------------
		 */
        $this->start_controls_section(
			'date_style',
            [
                'label'     => esc_html__('Date','essential-addons-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_date' => 'block'
                ]
            ]
        );

        $this->add_control(
			'date_color', 
            [
                'label'  => esc_html__('Color', 'essential-addons-elementor'),
                'type'   => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-social-date a' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
			'date_hover_color',
            [
                'label'  => esc_html__('Hover Color', 'essential-addons-elementor'),
                'type'   => Controls_Manager::COLOR,
                'scheme' => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors'     => [
                    '{{WRAPPER}} .eael-social-date:hover a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'date_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .eael-social-date a',
            ]
        ); 

        $this->add_responsive_control(
			'date_margin',
            [
                'label'      => esc_html__('Margin', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-social-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
		$this->end_controls_section(); # end of "Date"
		
		/**
		 *
		 * Tab Style: Section => General
		 * -------------------------------------------
		 */
        $this->start_controls_section(
			'general_style',
            [
                'label' => esc_html__('Container','essential-addons-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'container_background',
            [
                'label'     => esc_html__('Background', 'essential-addons-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eael-facebook-feed-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), 
            [
                'name'     => 'container_box_border',
                'selector' => '{{WRAPPER}} .eael-facebook-feed-wrapper',
            ]
        );

        $this->add_control(
			'container_box_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'essential-addons-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%' ,'em'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-facebook-feed-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .eael-facebook-feed-wrapper',
            ]
        );

        $this->add_responsive_control(
			'container_margin',
            [
                'label'      => esc_html__('Margin', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-facebook-feed-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
			'container_padding',
            [
                'label'      => esc_html__('Padding', 'essential-addons-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .eael-facebook-feed-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->end_controls_section(); # end of "General"
	}

	/**
	 * Retrive the responsive style based on 'Elementor Breakpoints'
	 * 
	 * @access	protected
	 * @return	string
	 */
	protected function render_facebook_responsive_style() {

		$breakpoints = Responsive::get_breakpoints();

		$style = "@media(max-width:{$breakpoints['lg']}px){";
			$style .= '.eael-social-feed-element-wrap {';
				$style .= 'width: 50% !important;';
			$style .= '}';
		$style .= "}";

		$style .= "@media(max-width:{$breakpoints['md']}px){";
			$style .= '.eael-social-feed-element-wrap {';
				$style .= 'width: 100% !important;';
			$style .= '}';
		$style .= "}";

		return $style;

	}


	protected function render() {
		$settings = $this->get_settings();

		$layout_class = $settings['facebook_feed_layout_style'] == 'list' ? 'list-layout' : 'grid-layout';
		$template     = $settings['facebook_feed_layout_style'] == 'list' ? 'list-template.php' : 'grid-template.php';
		$direction    = $settings['direction'];

		$limit          = !empty( $settings['post_limit'] ) ? $settings['post_limit'] : 130;
		$content_length = !empty( $settings['content_length'] ) ? $settings['content_length'] : 2;
		$show_media     = ( $settings['feed_media'] ) ? true : false;

		$facebook_settings = [
			'accounts'     => esc_html($settings['account_id']),
			'limit'        => $limit,
			'access_token' => esc_html($settings['access_token']),
			'length'       => $content_length,
			'showMedia'    => $show_media,
			'layout'       => $layout_class,
			'template'     => plugins_url( '/templates/', __FILE__ ) . $template
		];

		if( !empty($settings['access_token']) ) {
			$this->add_render_attribute(
				'eael-fb-feed',
				[
					'class'	=> [
						'eael-facebook-feed-wrapper',
						esc_attr($settings['feed_column_number']),
						esc_attr($direction)
					],
					'data-settings'	=> wp_json_encode($facebook_settings)
				]
			);

			$this->add_render_attribute(
				'eael-feed-container',
				[
					'id'	=> 'eael-social-feed-container-'.esc_attr($this->get_id()),
					'class'	=> [
						'eael-social-feed-container',
						esc_attr($layout_class)
					]
				]
			);
		}
	?>

	<?php if( empty($settings['access_token']) ) : ?>
		<div class="eael-fb-feed-error">
			<?php echo esc_html__('Please fill the required fields: App ID & Access Token!', 'essential-addons-elementor'); ?>
		</div>
	<?php else : ?>
		<div <?php echo $this->get_render_attribute_string('eael-fb-feed'); ?>>
			<div <?php echo $this->get_render_attribute_string('eael-feed-container'); ?>></div>
			<div class="eael-loading-feed"><div class="loader"></div></div>
		</div>
	<?php endif;
		echo "<style>".$this->render_facebook_responsive_style()."</style>";
	}

	protected function content_template() {}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_Eael_Facebook_Feed() );