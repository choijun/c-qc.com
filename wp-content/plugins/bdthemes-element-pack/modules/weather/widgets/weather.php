<?php
namespace ElementPack\Modules\Weather\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

use ElementPack\Element_Pack_Loader;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Weather extends Widget_Base {

	public function get_name() {
		return 'bdt-weather';
	}

	public function get_title() {
		return BDTEP . esc_html__( 'Weather', 'bdthemes-element-pack' );
	}

	public function get_icon() {
		return 'bdt-widget-icon eicon-divider-shape';
	}

	public function get_categories() {
		return [ 'element-pack' ];
	}

	public function get_style_depends() {
		return ['weather'];
	}

	public function get_script_depends() {
		return [ 'weather' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_weather',
			[
				'label' => esc_html__( 'Weather', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'api_type',
			[
				'label'   => esc_html__( 'Data Provider', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'yahoo',
				'options' => [
					'yahoo'          => esc_html__( 'Yahoo', 'bdthemes-element-pack' ),
					'openweathermap' => esc_html__( 'Open Weather Map', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label'   => esc_html__( 'Layout', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'full',
				'options' => [
					'full'     => esc_html__( 'Full', 'bdthemes-element-pack' ),
					'partial'  => esc_html__( 'Partial', 'bdthemes-element-pack' ),
					'simple'   => esc_html__( 'Simple', 'bdthemes-element-pack' ),
					'today'    => esc_html__( 'Today', 'bdthemes-element-pack' ),
					'forecast' => esc_html__( 'Forecast', 'bdthemes-element-pack' ),
					'tiny'     => esc_html__( 'Tiny', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'location',
			[
				'label'   => esc_html__( 'Location', 'bdthemes-element-pack' ),
				'description'   => esc_html__( 'City and Region required, for example: Boston, MA', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => 'Bogura',
			]
		);

		$this->add_control(
			'country',
			[
				'label'   => esc_html__( 'Country', 'bdthemes-element-pack' ),
				'description'   => esc_html__( 'Country required, for example: USA', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
				'default' => 'Bangladesh',
			]
		);

		$this->add_control(
			'units',
			[
				'label'   => esc_html__( 'Units', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'metric',
				'options' => [
					'auto'     => esc_html__( 'Auto', 'bdthemes-element-pack' ),
					'metric'   => esc_html__( 'Metric', 'bdthemes-element-pack' ),
					'imperial' => esc_html__( 'Imperial', 'bdthemes-element-pack' ),
				],
			]
		);

		$this->add_control(
			'timeformat',
			[
				'label'   => esc_html__( 'Time Format', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '12',
				'options' => [
					'12' => esc_html__( '12', 'bdthemes-element-pack' ),
					'24' => esc_html__( '24', 'bdthemes-element-pack' ),
				],
				'condition' => [
					'view!' => ['tiny']
				]
			]
		);

		$this->add_control(
			'displayCityNameOnly',
			[
				'label'   => esc_html__( 'Hide Country Name', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'view!' => ['tiny']
				]
			]
		);

		$this->add_control(
			'show_city',
			[
				'label'   => esc_html__( 'Show City Name', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'view' => ['tiny']
				]
			]
		);
		$this->add_control(
			'show_temperature',
			[
				'label'   => esc_html__( 'Show Temperature', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'view' => ['tiny']
				]
			]
		);
		$this->add_control(
			'show_weather_desc',
			[
				'label'   => esc_html__( 'Show Weather Description', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'view' => ['tiny']
				]
			]
		);

		$this->add_control(
			'forecast',
			[
				'label' => esc_html__( 'Forecast', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'default' => [
					'size' => 5,
				],
				'condition' => [
					'view!' => ['tiny']
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_weather',
			[
				'label' => esc_html__( 'Weather', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tiny_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather.bdt-weather-layout-tiny .wi:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'view' => 'tiny'
				]
			]
		);

		$this->add_control(
			'tiny_location_color',
			[
				'label'     => esc_html__( 'Location Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather.bdt-weather-layout-tiny .wi' => 'color: {{VALUE}};',
				],
				'condition' => [
					'view' => 'tiny'
				]
			]
		);

		$this->add_control(
			'tiny_unit_color',
			[
				'label'     => esc_html__( 'Unit Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather.bdt-weather-layout-tiny span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'view' => 'tiny'
				]
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Text Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather' => 'color: {{VALUE}};',
				],
				'condition' => [
					'view!' => ['simple', 'forecast']
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tiny_text_typography',
				'selector' => '{{WRAPPER}} .bdt-weather.bdt-weather-layout-tiny',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_location',
			[
				'label'     => esc_html__( 'Location', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'view!' => 'tiny'
				]
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-weather h2' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'title_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-weather h2',
			]
		);

		$this->add_control(
			'title_radius',
			[
				'label'      => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather h2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'title_shadow',
				'selector' => '{{WRAPPER}} .bdt-weather h2',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-weather h2',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_unit',
			[
				'label'     => esc_html__( 'Unit', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'view!' => 'tiny'
				]
			]
		);

		$this->add_control(
			'unit_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .wiMax'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .wiMin'         => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'unit_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'unit_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'unit_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'unit_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-weather .wiTemperature',
			]
		);

		$this->add_control(
			'unit_radius',
			[
				'label'      => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather .wiTemperature' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'unit_shadow',
				'selector' => '{{WRAPPER}} .bdt-weather .wiTemperature',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'unit_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-weather .wiTemperature',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icons', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'view!' => 'tiny'
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup'           => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .wiForecast .wi:before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .astronomy .wi:before'  => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-weather .atmosphere .wi:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background',
			[
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-weather .wiIconGroup',
			]
		);

		$this->add_control(
			'icon_radius',
			[
				'label'      => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-weather .wiIconGroup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-weather .wiIconGroup',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'icon_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-weather .wiIconGroup',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_days',
			[
				'label'     => esc_html__( 'Days', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'view!' => ['simple', 'today', 'tiny']
				]
			]
		);

		$this->add_control(
			'days_color',
			[
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiDetail .wiDay, {{WRAPPER}} .bdt-weather .wiDay span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'days_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .bdt-weather .wiDay span' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'days_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .bdt-weather .wiDetail .wiDay, {{WRAPPER}} .bdt-weather .wiDay span',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings        = $this->get_settings();
		$lang            = get_bloginfo('language');
		$lang            = strtoupper(substr($lang, 0, 2));
		$ep_api_settings = get_option( 'element_pack_api_settings' );
		$api_type        = 'yahoo';
		$api_key         = 'true';
		$city_only       = ('yes' == $settings['displayCityNameOnly']) ? 'true' : 'false';
 
		if ('openweathermap' == $settings['api_type']) {
			$api_type = 'openweathermap';
			$api_key  = !empty($ep_api_settings['open_weather_api_key']) ? $ep_api_settings['open_weather_api_key'] : '';
		}


		$this->add_render_attribute( 'weather', 'class', 'bdt-weather bdt-weather-layout-' . $settings['view'] );
		$this->add_render_attribute( 'weather', 'data-location', $settings['location'] );
		$this->add_render_attribute( 'weather', 'data-country', $settings['country'] );
		$this->add_render_attribute( 'weather', 'data-api', $settings['api_type'] );
		$this->add_render_attribute( 'weather', 'data-layout', $settings['view'] );
		$this->add_render_attribute( 'weather', 'data-timeformat', $settings['timeformat'] );
		$this->add_render_attribute( 'weather', 'data-city_only', $city_only );
		$this->add_render_attribute( 'weather', 'data-forecast', $settings['forecast']['size'] );
		$this->add_render_attribute( 'weather', 'data-units', $settings['units'] );
		$this->add_render_attribute( 'weather', 'data-lang', $lang );
		$this->add_render_attribute( 'weather', 'data-apikey', $api_key );
		
		if ('tiny' == $settings['view']) {
			$this->add_render_attribute( 'weather', 'data-show_city', $settings['show_city'] );
			$this->add_render_attribute( 'weather', 'data-show_weather_desc', $settings['show_weather_desc'] );
			$this->add_render_attribute( 'weather', 'data-show_temperature', $settings['show_temperature'] );
		}

		?>
		
		<?php if ($api_key) : ?>

			<div <?php echo $this->get_render_attribute_string( 'weather' ); ?>></div>

		<?php else : ?>
			<div class="bdt-alert-warning" bdt-alert>
			    <a class="bdt-alert-close" bdt-close></a>
			    <p><?php esc_html_e( 'Ops! I think you forget to set API key in settings.', 'bdthemes-element-pack' ); ?></p>
			</div>
		<?php endif; ?>

		<?php
	}
}
