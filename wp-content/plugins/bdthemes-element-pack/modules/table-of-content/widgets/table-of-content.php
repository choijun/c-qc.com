<?php
namespace ElementPack\Modules\TableOfContent\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Table_Of_Content extends Widget_Base {
	public function get_name() {
		return 'bdt-table-of-content';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Table of Content', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-navigation-vertical';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_script_depends() {
		return [ 'table-of-content', 'bdt-uikit-icon' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_offcanvas_button',
			[
				'label' => esc_html__( 'Button', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'ofc_btn_text',
			[
				'label'       => __( 'Button Text', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Show Content',
				'placeholder' => 'Type Button Tex',
			]
		);

		$this->add_control(
			'ofc_btn_icon',
			[
				'label'       => __( 'Button Icon', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'default'     => 'fa fa-bars',
			]
		);

		$this->add_control(
			'ofc_btn_icon_align',
			[
				'label'   => __( 'Icon Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'left'   => __( 'Left', 'bdthemes-element-pack' ),
					'right'  => __( 'Right', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'ofc_btn_icon!' => '',
				],
			]
		);

		$this->add_control(
			'ofc_btn_icon_indent',
			[
				'label' => __( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'default' => [
					'size' => 8,
				],
				'condition' => [
					'ofc_btn_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-button-icon-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-button-icon-align-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ofc_btn_pos',
			[
				'label'   => esc_html__( 'Button Position', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'options' => element_pack_position(),
				'default' => 'top-left',
			]
		);

		$this->add_responsive_control(
			'ofc_btn_horizontal_offset',
			[
				'label' => __( 'Horizontal Offset', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'ofc_btn_vertical_offset',
			[
				'label' => __( 'Vertical Offset', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -300,
						'step' => 2,
						'max'  => 300,
					],
				],
			]
		);

		$this->add_responsive_control(
			'ofc_btn_rotate',
			[
				'label'   => esc_html__( 'Rotate', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .bdt-offcanvas-button-wrapper' => 'transform: translate({{ofc_btn_horizontal_offset.SIZE}}px, {{ofc_btn_vertical_offset.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .bdt-offcanvas-button-wrapper' => 'transform: translate({{ofc_btn_horizontal_offset_tablet.SIZE}}px, {{ofc_btn_vertical_offset_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .bdt-offcanvas-button-wrapper' => 'transform: translate({{ofc_btn_horizontal_offset_mobile.SIZE}}px, {{ofc_btn_vertical_offset_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_offcanvas',
			[
				'label' => esc_html__( 'Offcanvas', 'bdthemes-element-pack' ),
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'      => esc_html__( 'Width', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range'      => [
					'px' => [
						'min' => 240,
						'max' => 1200,
					],
					'vw' => [
						'min' => 10,
						'max' => 100,
					]
				],
				'selectors' => [
					'#bdt-toc-{{ID}} .bdt-offcanvas-bar' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'index_align',
			[
				'label'   => esc_html__( 'Alignment', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'bdthemes-element-pack' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => 'right',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_table_of_content',
			[
				'label' => esc_html__( 'Table of Content', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'start_tag',
			[
				'label'   => __( 'Start Tag', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1'   => esc_html__( 'H1', 'bdthemes-element-pack' ),
			        '2'   => esc_html__( 'H2', 'bdthemes-element-pack' ),
			        '3'   => esc_html__( 'H3', 'bdthemes-element-pack' ),
			        '4'   => esc_html__( 'H4', 'bdthemes-element-pack' ),
			        '5'   => esc_html__( 'H5', 'bdthemes-element-pack' ),
			        '6'   => esc_html__( 'H6', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'end_tag',
			[
				'label'   => __( 'End Tag', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '5',
				'options' => [
					'1'   => esc_html__( 'H1', 'bdthemes-element-pack' ),
			        '2'   => esc_html__( 'H2', 'bdthemes-element-pack' ),
			        '3'   => esc_html__( 'H3', 'bdthemes-element-pack' ),
			        '4'   => esc_html__( 'H4', 'bdthemes-element-pack' ),
			        '5'   => esc_html__( 'H5', 'bdthemes-element-pack' ),
			        '6'   => esc_html__( 'H6', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => __( 'Scroll Offset', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_ofc_btn',
			[
				'label' => esc_html__( 'Button', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ofc_btn_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-offcanvas-button-wrapper a.bdt-offcanvas-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ofc_btn_color',
			[
				'label'     => __( 'Icon Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-offcanvas-button-wrapper a.bdt-offcanvas-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ofc_btn_shadow',
				'selector' => '{{WRAPPER}} .bdt-offcanvas-button-wrapper a.bdt-offcanvas-button'
			]
		);

		$this->add_responsive_control(
			'ofc_btn_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-offcanvas-button-wrapper a.bdt-offcanvas-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ofc_btn_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-offcanvas-button-wrapper a.bdt-offcanvas-button'
			]
		);

		$this->add_control(
			'ofc_btn_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-offcanvas-button-wrapper a.bdt-offcanvas-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ofc_btn_typography',
				'selector' => '{{WRAPPER}} .bdt-offcanvas-button-wrapper a.bdt-offcanvas-button',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_offcanvas',
			[
				'label' => esc_html__( 'Offcanvas', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'index_background',
			[
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-toc-{{ID}} .bdt-offcanvas-bar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-toc-{{ID}} .bdt-offcanvas-bar .bdt-nav li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_active_color',
			[
				'label'     => __( 'Active Title Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-toc-{{ID}} .bdt-offcanvas-bar .bdt-nav > li.bdt-active > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_style_active_color',
			[
				'label'     => __( 'Title Style Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'#bdt-toc-{{ID}} .bdt-offcanvas-bar .bdt-nav li > a:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->end_controls_section();
	}	

	protected function render() {
		$settings    = $this->get_settings();
		$id          = 'bdt-toc-' . $this->get_id();		
		$index_align = $settings['index_align'] ? : 'right';

		if ($settings['ofc_btn_icon']) {
			$ofc_btn_icon = $settings['ofc_btn_icon'];
		} else {
			if ($settings['ofc_btn_text']) {
				$ofc_btn_icon = '';
			} else {
				$ofc_btn_icon = 'fa fa-bars';
			}			
		}
		
						

		$this->add_render_attribute( 'offcanvas', 'id',  esc_attr($id));
		$this->add_render_attribute( 'offcanvas', 'class',  ['bdt-offcanvas', 'bdt-ofc-table-of-content', 'bdt-flex', 'bdt-flex-middle']);

		if ( 'right' == $index_align ) {
			$this->add_render_attribute( 'offcanvas', 'bdt-offcanvas',  'flip: true');
		} else {
			$this->add_render_attribute( 'offcanvas', 'bdt-offcanvas',  '');
		}

		?>
		<div class="bdt-table-of-content">
			<div class="bdt-offcanvas-button-wrapper bdt-position-fixed bdt-position-<?php echo esc_attr($settings['ofc_btn_pos']); ?>">
				<a class="bdt-offcanvas-button elementor-button elementor-size-sm" bdt-toggle="target: #<?php echo esc_attr($id); ?>" href="javascript:void(0)">
					<span class="elementor-button-content-wrapper">

						<?php if ($settings['ofc_btn_text']) : ?>
							<span class="bdt-offcanvas-button-text">
								<?php echo esc_html( $settings['ofc_btn_text'] ); ?>
							</span>
						<?php endif; ?>

						<?php if ($ofc_btn_icon) : ?>
							<span class="bdt-offcanvas-button-icon elementor-button-icon bdt-button-icon-align-<?php echo esc_attr($settings['ofc_btn_icon_align']); ?>">
								<i class="<?php echo esc_attr( $ofc_btn_icon ); ?>" aria-hidden="true"></i>
							</span>
						<?php endif; ?>

					</span>
				</a>
			</div>

			<div <?php echo $this->get_render_attribute_string( 'offcanvas' ); ?>>
				<div class="bdt-offcanvas-bar">
					<button class="bdt-offcanvas-close" type="button" bdt-close></button>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#<?php echo esc_attr($id); ?> .bdt-offcanvas-bar').TableOfContent({
					tH: <?php echo esc_attr($settings['start_tag']); ?>, //lowest-level header to be included (H2)
					bH: <?php echo esc_attr($settings['end_tag']); ?>, //highest-level header to be included (H6)
					offset: <?php echo esc_attr($settings['offset']['size']); ?> //offset for scrollspy	
				});
			});
		</script>
		<?php
	}
}
