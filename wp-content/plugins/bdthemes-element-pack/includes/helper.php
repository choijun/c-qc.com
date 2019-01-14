<?php
use ElementPack\Element_Pack_Loader;


/**
 * Show any alert by this function
 * @param  mixed  $message [description]
 * @param  class prefix  $type    [description]
 * @param  boolean $close   [description]
 * @return helper           [description]
 */
function element_pack_alert($message, $type = 'warning', $close = true) {
    ?>
    <div class="bdt-alert-<?php echo $type; ?>" bdt-alert>
        <?php if($close) : ?>
            <a class="bdt-alert-close" bdt-close></a>
        <?php endif; ?>
        <?php echo wp_kses_post( $message ); ?>
    </div>
    <?php
}

/**
 * all array css classes will output as proper space
 * @param array $classes shortcode css class as array
 * @return proper string
 */

function bdt_get_post_types(){

    $cpts = get_post_types( array( 'public'   => true, 'show_in_nav_menus' => true ) );
    $exclude_cpts = array( 'elementor_library', 'attachment', 'product' );

    foreach ( $exclude_cpts as $exclude_cpt ) {
        unset($cpts[$exclude_cpt]);
    }

    $post_types = array_merge($cpts);
    return $post_types;
}

/**
 * Add REST API support to an already registered post type.
 */

// function bdt_custom_post_type_rest_support() {
//     global $wp_post_types;

//     $post_types = bdt_get_post_types();
//     foreach( $post_types as $post_type ) {
//         $post_type_name = $post_type;
//         if( isset( $wp_post_types[ $post_type_name ] ) ) {
//             $wp_post_types[$post_type_name]->show_in_rest = true;
//             $wp_post_types[$post_type_name]->rest_base = $post_type_name;
//             $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
//         }
//     }

// }

// add_action( 'init', 'bdt_custom_post_type_rest_support', 25 );

/**
 * subscribe mailchimp with api key
 * @param  string $email        any valid email
 * @param  string $status       subscribe or unsubscribe
 * @param  array  $merge_fields First name and last name of subscriber
 * @return [type]               [description]
 */
function element_pack_mailchimp_subscriber_status( $email, $status, $merge_fields = array('FNAME' => '','LNAME' => '') ){

    $options = get_option( 'element_pack_api_settings' );
    $list_id = (!empty($options['mailchimp_list_id'])) ? $options['mailchimp_list_id'] : ''; // Your list is here
    $api_key = (!empty($options['mailchimp_api_key'])) ? $options['mailchimp_api_key'] : ''; // Your mailchimp api key here

    $data = array(
        'apikey'        => $api_key,
        'email_address' => $email,
        'status'        => $status,
        'merge_fields'  => $merge_fields
    );
    $mailchimp_api = curl_init(); // init cURL connection
 
    curl_setopt($mailchimp_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($data['email_address'])));
    curl_setopt($mailchimp_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($mailchimp_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mailchimp_api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($mailchimp_api, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($mailchimp_api, CURLOPT_TIMEOUT, 10);
    curl_setopt($mailchimp_api, CURLOPT_POST, true);
    curl_setopt($mailchimp_api, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($mailchimp_api, CURLOPT_POSTFIELDS, json_encode($data) );
 
    $result = curl_exec($mailchimp_api);

    return $result;
}


if (!function_exists('element_pack_allow_tags')) {
    function element_pack_allow_tags($tag = null) {
        $tag_allowed = wp_kses_allowed_html('post');

        $tag_allowed['input'] = array(
            'class'   => [],
            'id'      => [],
            'name'    => [],
            'value'   => [],
            'checked' => [],
            'type'    => []
        );
        $tag_allowed['select'] = array(
            'class'    => [],
            'id'       => [],
            'name'     => [],
            'value'    => [],
            'multiple' => [],
            'type'     => []
        );
        $tag_allowed['option'] = array(
            'value'    => [],
            'selected' => []
        );

        if($tag == null){
            return $tag_allowed;
        }
        elseif(is_array($tag)){
            $new_tag_allow = [];
            foreach ($tag as $_tag){
                $new_tag_allow[$_tag] = $tag_allowed[$_tag];
            }

            return $new_tag_allow;
        }
        else{
            return isset($tag_allowed[$tag]) ? array($tag=>$tag_allowed[$tag]) : [];
        }
    }
}

/**
 * post pagination
 */
function element_pack_post_pagination($wp_query) {

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<ul class="bdt-pagination bdt-flex-center">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link('<span bdt-pagination-previous></span>') );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="current"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li class="bdt-pagination-dot-dot"><span>...</span></li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="bdt-active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="bdt-pagination-dot-dot"><span>...</span></li>' . "\n";

        $class = $paged == $max ? ' class="bdt-active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link('<span bdt-pagination-next></span>') );

    echo '</ul>' . "\n";
}


function element_pack_iso_time($time) {
    $current_offset = (float) get_option( 'gmt_offset' );
    $timezone_string = get_option( 'timezone_string' );

    // Create a UTC+- zone if no timezone string exists.
    //if ( empty( $timezone_string ) ) {
        if ( 0 === $current_offset ) {
            $timezone_string = '+00:00';
        } elseif ( $current_offset < 0 ) {
            $timezone_string = $current_offset . ':00';
        } else {
            $timezone_string = '+0' . $current_offset . ':00';
        }
    //}

    $sub_time = [];
    $sub_time = explode(" ", $time);
    $final_time = $sub_time[0] .'T'. $sub_time[1] .':00' . $timezone_string;

    return $final_time;
}


/**
 * Make sure elementor plugin installed or not
 * @return error message
 */
function bdthemes_elementor_not_found() {
    $class = 'notice notice-error';
    $message = __( 'Ops! Elementor Plugin Not Found! Make sure you installed and Activated correctly.', 'bdthemes-element-pack' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

function element_pack_get_menu() {
    $menus = wp_get_nav_menus();
    $items = ['0' => esc_html__( 'Select Menu', 'bdthemes-element-pack' ) ];
    foreach ( $menus as $menu ) {
        $items[ $menu->slug ] = $menu->name;
    }

    return $items;
}

/**
 * default get_option() default value check
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * @return mixed
 */
function element_pack_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}

// Anywhere Template
function element_pack_ae_options() {    
    if (post_type_exists('ae_global_templates')) {
        $anywhere = get_posts(array(
            'fields'         => 'ids', // Only get post IDs
            'posts_per_page' => -1,
            'post_type'      => 'ae_global_templates',
        ));

        $anywhere_options = ['0' => esc_html__( 'Select Template', 'bdthemes-element-pack' ) ];

        foreach ($anywhere as $key => $value) {
            $anywhere_options[$value] = get_the_title($value);
        }        
    } else {
        $anywhere_options = ['0' => esc_html__( 'AE Plugin Not Installed', 'bdthemes-element-pack' ) ];
    }
    return $anywhere_options;
}

// Elementor Saved Template 
function element_pack_et_options() {
    $templates = Element_Pack_Loader::elementor()->templates_manager->get_source( 'local' )->get_items();
    $types     = [];

    if ( empty( $templates ) ) {
        $template_options = [ '0' => __( 'You Haven’t Saved Templates Yet.', 'bdthemes-element-pack' ) ];
    } else {
        $template_options = [ '0' => __( 'Select Template', 'bdthemes-element-pack' ) ];
        
        foreach ( $templates as $template ) {
            $template_options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }
    }

    return $template_options;
}

// Sidebar Widgets
function element_pack_sidebar_options() {
    global $wp_registered_sidebars;
    $sidebar_options = [];

    if ( ! $wp_registered_sidebars ) {
        $sidebar_options['0'] = esc_html__( 'No sidebars were found', 'bdthemes-element-pack' );
    } else {
        $sidebar_options['0'] = esc_html__( 'Select Sidebar', 'bdthemes-element-pack' );

        foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar ) {
            $sidebar_options[ $sidebar_id ] = $sidebar['name'];
        }
    }

    return $sidebar_options;
}

// BDT Transition
function element_pack_transition_options() {
    $transition_options = [
        ''                    => esc_html__('None', 'bdthemes-element-pack'),
        'fade'                => esc_html__('Fade', 'bdthemes-element-pack'),
        'scale-up'            => esc_html__('Scale Up', 'bdthemes-element-pack'),
        'scale-down'          => esc_html__('Scale Down', 'bdthemes-element-pack'),
        'slide-top'           => esc_html__('Slide Top', 'bdthemes-element-pack'),
        'slide-bottom'        => esc_html__('Slide Bottom', 'bdthemes-element-pack'),
        'slide-left'          => esc_html__('Slide Left', 'bdthemes-element-pack'),
        'slide-right'         => esc_html__('Slide Right', 'bdthemes-element-pack'),
        'slide-top-small'     => esc_html__('Slide Top Small', 'bdthemes-element-pack'),
        'slide-bottom-small'  => esc_html__('Slide Bottom Small', 'bdthemes-element-pack'),
        'slide-left-small'    => esc_html__('Slide Left Small', 'bdthemes-element-pack'),
        'slide-right-small'   => esc_html__('Slide Right Small', 'bdthemes-element-pack'),
        'slide-top-medium'    => esc_html__('Slide Top Medium', 'bdthemes-element-pack'),
        'slide-bottom-medium' => esc_html__('Slide Bottom Medium', 'bdthemes-element-pack'),
        'slide-left-medium'   => esc_html__('Slide Left Medium', 'bdthemes-element-pack'),
        'slide-right-medium'  => esc_html__('Slide Right Medium', 'bdthemes-element-pack'),
    ];

    return $transition_options;
}

// BDT Blend Type
function element_pack_blend_options() {
    $blend_options = [
        'multiply'    => esc_html__( 'Multiply', 'bdthemes-element-pack' ),
        'screen'      => esc_html__( 'Screen', 'bdthemes-element-pack' ),
        'overlay'     => esc_html__( 'Overlay', 'bdthemes-element-pack' ),
        'darken'      => esc_html__( 'Darken', 'bdthemes-element-pack' ),
        'lighten'     => esc_html__( 'Lighten', 'bdthemes-element-pack' ),
        'color-dodge' => esc_html__( 'Color-Dodge', 'bdthemes-element-pack' ),
        'color-burn'  => esc_html__( 'Color-Burn', 'bdthemes-element-pack' ),
        'hard-light'  => esc_html__( 'Hard-Light', 'bdthemes-element-pack' ),
        'soft-light'  => esc_html__( 'Soft-Light', 'bdthemes-element-pack' ),
        'difference'  => esc_html__( 'Difference', 'bdthemes-element-pack' ),
        'exclusion'   => esc_html__( 'Exclusion', 'bdthemes-element-pack' ),
        'hue'         => esc_html__( 'Hue', 'bdthemes-element-pack' ),
        'saturation'  => esc_html__( 'Saturation', 'bdthemes-element-pack' ),
        'color'       => esc_html__( 'Color', 'bdthemes-element-pack' ),
        'luminosity'  => esc_html__( 'Luminosity', 'bdthemes-element-pack' ),
    ];

    return $blend_options;
}

// BDT Position
function element_pack_position() {
    $position_options = [
        ''              => esc_html__('Default', 'bdthemes-element-pack'),
        'top-left'      => esc_html__('Top Left', 'bdthemes-element-pack') ,
        'top-center'    => esc_html__('Top Center', 'bdthemes-element-pack') ,
        'top-right'     => esc_html__('Top Right', 'bdthemes-element-pack') ,
        'center'        => esc_html__('Center', 'bdthemes-element-pack') ,
        'center-left'   => esc_html__('Center Left', 'bdthemes-element-pack') ,
        'center-right'  => esc_html__('Center Right', 'bdthemes-element-pack') ,
        'bottom-left'   => esc_html__('Bottom Left', 'bdthemes-element-pack') ,
        'bottom-center' => esc_html__('Bottom Center', 'bdthemes-element-pack') ,
        'bottom-right'  => esc_html__('Bottom Right', 'bdthemes-element-pack') ,
    ];

    return $position_options;
}

// BDT Thumbnavs Position
function element_pack_thumbnavs_position() {
    $position_options = [
        'top-left'      => esc_html__('Top Left', 'bdthemes-element-pack') ,
        'top-center'    => esc_html__('Top Center', 'bdthemes-element-pack') ,
        'top-right'     => esc_html__('Top Right', 'bdthemes-element-pack') ,
        'center-left'   => esc_html__('Center Left', 'bdthemes-element-pack') ,
        'center-right'  => esc_html__('Center Right', 'bdthemes-element-pack') ,
        'bottom-left'   => esc_html__('Bottom Left', 'bdthemes-element-pack') ,
        'bottom-center' => esc_html__('Bottom Center', 'bdthemes-element-pack') ,
        'bottom-right'  => esc_html__('Bottom Right', 'bdthemes-element-pack') ,
    ];

    return $position_options;
}

function element_pack_navigation_position() {
    $position_options = [
        'top-left'      => esc_html__('Top Left', 'bdthemes-element-pack') ,
        'top-center'    => esc_html__('Top Center', 'bdthemes-element-pack') ,
        'top-right'     => esc_html__('Top Right', 'bdthemes-element-pack') ,
        'center'        => esc_html__('Center', 'bdthemes-element-pack') ,
        'bottom-left'   => esc_html__('Bottom Left', 'bdthemes-element-pack') ,
        'bottom-center' => esc_html__('Bottom Center', 'bdthemes-element-pack') ,
        'bottom-right'  => esc_html__('Bottom Right', 'bdthemes-element-pack') ,
    ];

    return $position_options;
}


function element_pack_pagination_position() {
    $position_options = [
        'top-left'      => esc_html__('Top Left', 'bdthemes-element-pack') ,
        'top-center'    => esc_html__('Top Center', 'bdthemes-element-pack') ,
        'top-right'     => esc_html__('Top Right', 'bdthemes-element-pack') ,
        'bottom-left'   => esc_html__('Bottom Left', 'bdthemes-element-pack') ,
        'bottom-center' => esc_html__('Bottom Center', 'bdthemes-element-pack') ,
        'bottom-right'  => esc_html__('Bottom Right', 'bdthemes-element-pack') ,
    ];

    return $position_options;
}

// BDT Drop Position
function element_pack_drop_position() {
    $drop_position_options = [
        'bottom-left'    => esc_html__('Bottom Left', 'bdthemes-element-pack'),
        'bottom-center'  => esc_html__('Bottom Center', 'bdthemes-element-pack'),
        'bottom-right'   => esc_html__('Bottom Right', 'bdthemes-element-pack'),
        'bottom-justify' => esc_html__('Bottom Justify', 'bdthemes-element-pack'),
        'top-left'       => esc_html__('Top Left', 'bdthemes-element-pack'),
        'top-center'     => esc_html__('Top Center', 'bdthemes-element-pack'),
        'top-right'      => esc_html__('Top Right', 'bdthemes-element-pack'),
        'top-justify'    => esc_html__('Top Justify', 'bdthemes-element-pack'),
        'left-top'       => esc_html__('Left Top', 'bdthemes-element-pack'),
        'left-center'    => esc_html__('Left Center', 'bdthemes-element-pack'),
        'left-bottom'    => esc_html__('Left Bottom', 'bdthemes-element-pack'),
        'right-top'      => esc_html__('Right Top', 'bdthemes-element-pack'),
        'right-center'   => esc_html__('Right Center', 'bdthemes-element-pack'),
        'right-bottom'   => esc_html__('Right Bottom', 'bdthemes-element-pack'),
    ];

    return $drop_position_options;
}

// Button Size
function element_pack_button_sizes() {
    $button_sizes = [
        'xs' => esc_html__( 'Extra Small', 'bdthemes-element-pack' ),
        'sm' => esc_html__( 'Small', 'bdthemes-element-pack' ),
        'md' => esc_html__( 'Medium', 'bdthemes-element-pack' ),
        'lg' => esc_html__( 'Large', 'bdthemes-element-pack' ),
        'xl' => esc_html__( 'Extra Large', 'bdthemes-element-pack' ),
    ];

    return $button_sizes;
}

// Title Tags
function element_pack_title_tags() {
    $title_tags = [
        'h1'   => esc_html__( 'H1', 'bdthemes-element-pack' ),
        'h2'   => esc_html__( 'H2', 'bdthemes-element-pack' ),
        'h3'   => esc_html__( 'H3', 'bdthemes-element-pack' ),
        'h4'   => esc_html__( 'H4', 'bdthemes-element-pack' ),
        'h5'   => esc_html__( 'H5', 'bdthemes-element-pack' ),
        'h6'   => esc_html__( 'H6', 'bdthemes-element-pack' ),
        'div'  => esc_html__( 'div', 'bdthemes-element-pack' ),
        'span' => esc_html__( 'span', 'bdthemes-element-pack' ),
        'p'    => esc_html__( 'p', 'bdthemes-element-pack' ),
    ];

    return $title_tags;
}
/**
 * This is a svg arrows pack function which return a svg content 
 * @param  string $arrow arrow type
 * @return svg content
 */
function element_pack_icon_box_arrows($arrow) {

    if ($arrow == '1') {
        $output = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><path d="M145.2,26.8c0.3,5.3,0.7,10.5,1.1,15.8c-10.5-10.1-19.1-22.4-31-30.9C104.7,4.1,91.9,0.9,79,1.4C48.2,2.5,22.3,22.7,0.4,42.5c-0.8,0.7,0.2,2,1.1,1.3c23.4-18.3,47.6-39.2,79-39.8c13.4-0.2,26,3.8,36.5,12.2c10,8.1,17.7,18.5,26.8,27.5C137,42,130.5,40,124,37.8c-1.1-0.4-1.7,1.2-0.6,1.7c7.8,3.4,15.9,5.9,24.2,7.9c0.1,0,0.1,0,0.2,0c0.1,0.1,0.2,0.2,0.2,0.2c1.3,1.2,2.9-1.1,1.6-2.2c-0.1-0.1-0.2-0.2-0.3-0.2c-0.4-6.3-0.8-12.6-1.4-18.9C147.7,24.6,145.1,25,145.2,26.8z"/></svg>';
    } elseif ($arrow == '2') {
        $output = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><path d="M137,10.3c2.7,5.7,4.5,12.2,6.5,18.2c0.4,1.3-1,2.6-2.2,2.2c-6.7-2.3-13.5-4.5-20.3-6.8c-1.8-0.6-1.1-3.4,0.7-2.8c3.2,0.9,6.5,1.9,9.7,2.9c0-0.1-0.1-0.1-0.1-0.2c-3.7-6.4-13.1-18.6-20.2-7.5c-2.3,3.7-2.6,8.7-3.8,12.8c-1.5,5-4.3,9.8-10,10.3c-6.2,0.5-10.7-4.9-13.6-9.6c-2.6-4.4-4.6-9.3-6.8-13.9c-0.7-1.6-1.5-3.2-2.3-4.8c-2.8-4.2-6.4-4.2-8.5-4.1c-4.3,0.2-8.4,5.4-10.7,8.6c-6.2,8.6-9.8,41.1-27.6,32.9C12.2,41.2,6.5,16.6,7.9,1.1c0.1-1.2,1.9-1.2,1.9,0c-0.1,11.7,2.5,23.1,8.8,33c3.8,6.1,9.8,14,18.2,11c5.3-1.9,7.1-11.7,8.6-16.3c3.1-9.7,16.7-35.6,30.3-23c6.8,6.4,7.8,17.8,13.8,25c11.8,14.2,14.5-6.5,17.4-13.9c2.1-5.2,5.9-9.1,11.9-8.7c7.9,0.4,12.6,7.3,15.8,13.7c0.6,1.1-0.1,2.1-1,2.5c1.8,0.5,3.6,1.1,5.3,1.6c-1.9-4.8-3.8-9.6-5-14.5C133.4,9.7,136.2,8.4,137,10.3z"/></svg>';
    } elseif ($arrow == '3') {
        $output = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><path d="M4.3,12.3c2.9,6.7,5.6,14.2,11.3,19.2c9.3,8.1,20.4,2,29-3.8c12.7-8.5,23.8-20,39-24c26.5-7.1,55,9.2,61.4,35.8c0.7-3.1,1.2-6.2,1.7-9.4c0.2-1.2,2-0.9,2.1,0.3c0.2,5.5-1.1,11.2-2.4,16.5c-0.3,1.2-2,1.7-2.8,0.7c-4-4.8-8.4-9.2-12.4-14c-1.4-1.7,0.7-3.7,2.4-2.4c3.6,2.8,6.8,6.5,9.7,10.3c-5.2-16.6-17.2-30.3-34.7-34.5c-19-4.6-34.8,3.5-49.5,14.7C49.1,29.1,35.7,41.7,22.2,39C10.7,36.7,4.3,23.8,1.4,13.5C0.9,11.9,3.5,10.6,4.3,12.3z"/></svg>';
    } elseif ($arrow == '4') {
        $output = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><path d="M128,27.9c-1.2,6.2-1.9,11.7-4.4,17.3c-0.6-0.7-1.1-1.4-1.7-2.1c2.6-21.9-14.6-42.5-37.3-40.7c-2.1,0.2-4.4,0.7-6.6,1.4C67-1.4,52.2-1,41.8,3.5c-9.7,4.3-17.6,12.1-22,21.8c-3.5,7.6-6.2,18.8,1.7,24.5c1,0.7,2.2-0.6,1.3-1.4c-10.1-8,0.1-25.4,6.5-32.4C36,8.7,45.3,4.1,55.2,3.1c6.1-0.6,12.7,0.1,18.5,2.5C61.2,11.5,51,25,61.5,37.7c12.3,14.9,33.9,1.1,30.4-16.3c-1.4-6.7-5.1-11.7-10.1-15.2c1.6-0.3,3.2-0.4,4.7-0.5c19.2-0.4,32.2,15.8,32.3,33.8c-2.8-3.4-5.6-6.8-8.5-10c-0.8-0.9-2.3,0.4-1.6,1.4c3.2,4.5,6.6,8.8,10,13.2c0.1,0.5,0.4,0.9,0.8,1.1c1,1.3,2,2.6,3,3.9c0.7,1,2.1,1,2.8-0.1c3.4-6,6.2-13.7,5.2-20.7C130.3,26.8,128.3,26.4,128,27.9z M80.1,39.5c-14.7,5.8-24.2-11.8-15.8-23.1c3.2-4.3,7.9-7.4,13-9.1c2.1,1.2,4,2.6,5.8,4.4C90.9,19.5,91.9,34.9,80.1,39.5z"/></svg>';
    } elseif ($arrow == '5') {
        $output = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 50"><g><path class="st0" d="M5.7,40.9c-0.8-0.1-1.5,0.5-1.5,1.3c-0.1,0.8,0.5,1.5,1.3,1.5C6.3,43.8,7,43.2,7,42.5    C7.1,41.7,6.5,41,5.7,40.9z"/><circle class="st0" cx="10.4" cy="36.6" r="1.7"/><path class="st0" d="M15.8,29c-1.1-0.1-2,0.7-2.1,1.8c-0.1,1.1,0.7,2,1.8,2.1c1.1,0.1,2-0.7,2.1-1.8S16.8,29,15.8,29z"/><path class="st0" d="M21.8,22.9c-1.1-0.1-2.1,0.8-2.2,1.9c-0.1,1.1,0.8,2.1,1.9,2.2c1.1,0.1,2.1-0.8,2.2-1.9    C23.8,24,22.9,23,21.8,22.9z"/><circle class="st0" cx="28.3" cy="19.9" r="2"/><path class="st0" d="M36.2,12.7c-1.1-0.1-2.1,0.8-2.2,1.9c-0.1,1.1,0.8,2.1,1.9,2.2c1.1,0.1,2.1-0.8,2.2-1.9    C38.2,13.7,37.4,12.8,36.2,12.7z"/><path class="st0" d="M55.4,5.8c-1.2-0.1-2.2,0.8-2.3,2c-0.1,1.2,0.8,2.2,2,2.3c1.2,0.1,2.2-0.8,2.3-2C57.5,6.9,56.6,5.8,55.4,5.8z"    /><path class="st0" d="M45.5,8.8c-1.2-0.1-2.3,0.8-2.3,2c-0.1,1.2,0.8,2.3,2,2.3c1.2,0.1,2.3-0.8,2.3-2C47.6,9.9,46.7,8.9,45.5,8.8z"    /><circle class="st0" cx="65.9" cy="6" r="2.4"/><circle class="st0" cx="76.8" cy="4.8" r="2.4"/><circle class="st0" cx="88.7" cy="6.1" r="2.4"/><circle class="st0" cx="99.9" cy="9.4" r="2.4"/><circle class="st0" cx="109.7" cy="13.4" r="2.4"/><circle class="st0" cx="119.6" cy="19.1" r="2.4"/><circle class="st0" cx="128.5" cy="25.6" r="2.4"/><circle class="st0" cx="135.3" cy="32.5" r="2.4"/><circle class="st0" cx="142.6" cy="41.8" r="2.4"/><circle class="st0" cx="143.1" cy="34.7" r="2.4"/><circle class="st0" cx="143.6" cy="27.9" r="2.4"/><circle class="st0" cx="144.1" cy="21" r="2.4"/><circle class="st0" cx="120.9" cy="40.3" r="2.4"/><circle class="st0" cx="127.8" cy="40.8" r="2.4"/><circle class="st0" cx="134.6" cy="41.3" r="2.4"/></g></svg>';
    }

    return $output;
}


function element_pack_parse_csv($file) {
    $skip_char = $column = '';
    $csv_lines = file( $file );
    if ( is_array( $csv_lines ) ) {
        $cnt = count( $csv_lines );
        for ( $i = 0; $i < $cnt; $i++ ) {
            $line = $csv_lines[$i];
            $line = trim( $line );
            $first_char = true;
            $col_num = 0;
            $length = strlen( $line );
            for ( $b = 0; $b < $length; $b++ ) {
                if ( $skip_char != true ) {
                    $process = true;
                    if ( $first_char == true ) {
                        if ( $line[$b] == '"' ) {
                            $terminator = '";';
                            $process = false;
                        }
                        else
                            $terminator = ';';
                        $first_char = false;
                    }
                    if ( $line[$b] == '"' ) {
                        $next_char = $line[$b + 1];
                        if ( $next_char == '"' ) $skip_char = true;
                        elseif ( $next_char == ';' ) {
                            if ( $terminator == '";' ) {
                                $first_char = true;
                                $process = false;
                                $skip_char = true;
                            }
                        }
                    }
                    if ( $process == true ) {
                        if ( $line[$b] == ';' ) {
                            if ( $terminator == ';' ) {
                                $first_char = true;
                                $process = false;
                            }
                        }
                    }
                    if ( $process == true ) $column .= $line[$b];
                    if ( $b == ( $length - 1 ) ) $first_char = true;
                    if ( $first_char == true ) {
                        $values[$i][$col_num] = $column;
                        $column = '';
                        $col_num++;
                    }
                }
                else
                    $skip_char = false;
            }
        }
    }
    $return = '<table><thead><tr>';
    foreach ( $values[0] as $value ) $return .= '<th>' . $value . '</th>';
    $return .= '</tr></thead><tbody>';
    array_shift( $values );
    foreach ( $values as $rows ) {
        $return .= '<tr>';
        foreach ( $rows as $col ) {
            $return .= '<td>' . $col . '</td>';
        }
        $return .= '</tr>';
    }
    $return .= '</tbody></table>';
    return $return;
}


/**
 * Ninja form array creator for get all form as 
 * @return array [description]
 */
function element_pack_ninja_forms_options() {
    $form_options = [];
    if ( class_exists( 'Ninja_Forms' ) ) {
        $ninja_forms  = Ninja_Forms()->form()->get_forms();
        if ( ! empty( $ninja_forms ) && ! is_wp_error( $ninja_forms ) ) {
            $form_options = ['0' => esc_html__( 'Select Form', 'bdthemes-element-pack' )];
            foreach ( $ninja_forms as $form ) {   
                $form_options[ $form->get_id() ] = $form->get_setting( 'title' );
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'bdthemes-element-pack' ) ];
    }

    return $form_options;
}

function element_pack_caldera_forms_options() {
    if ( class_exists( 'Caldera_Forms' ) ) {
        $caldera_forms = Caldera_Forms_Forms::get_forms( true, true );
        $form_options  = ['0' => esc_html__( 'Select Form', 'bdthemes-element-pack' )];
        $form          = [];
        if ( ! empty( $caldera_forms ) && ! is_wp_error( $caldera_forms ) ) {
            foreach ( $caldera_forms as $form ) {
                if ( isset($form['ID']) and isset($form['name'])) {
                    $form_options[$form['ID']] = $form['name'];
                }   
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'bdthemes-element-pack' ) ];
    }

    return $form_options;
}

function element_pack_quform_options() {
    if ( class_exists( 'Quform' ) ) {
        $quform       = Quform::getService('repository');
        $quform       = $quform->formsToSelectArray();
        $form_options = ['0' => esc_html__( 'Select Form', 'bdthemes-element-pack' )];
        if ( ! empty( $quform ) && ! is_wp_error( $quform ) ) {
            foreach ( $quform as $id => $name ) {
                $form_options[esc_attr( $id )] = esc_html( $name );
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'bdthemes-element-pack' ) ];
    }

    return $form_options;
}


function element_pack_gravity_forms_options() {
    if ( class_exists( 'GFCommon' ) ) {
        $contact_forms = RGFormsModel::get_forms( null, 'title' );
        $form_options = ['0' => esc_html__( 'Select Form', 'bdthemes-element-pack' )];
        if ( ! empty( $contact_forms ) && ! is_wp_error( $contact_forms ) ) {
            foreach ( $contact_forms as $form ) {   
                $form_options[ $form->id ] = $form->title;
            }
        }
    } else {
        $form_options = ['0' => esc_html__( 'Form Not Found!', 'bdthemes-element-pack' ) ];
    }

    return $form_options;
}


function element_pack_rev_slider_options() {
    if( class_exists( 'RevSlider' ) ){
        $slider             = new RevSlider();
        $revolution_sliders = $slider->getArrSliders();
        $slider_options     = ['0' => esc_html__( 'Select Slider', 'bdthemes-element-pack' ) ];
        if ( ! empty( $revolution_sliders ) && ! is_wp_error( $revolution_sliders ) ) {
            foreach ( $revolution_sliders as $revolution_slider ) {
               $alias = $revolution_slider->getAlias();
               $title = $revolution_slider->getTitle();
               $slider_options[$alias] = $title;
            }
        }
    } else {
        $slider_options = ['0' => esc_html__( 'No Slider Found!', 'bdthemes-element-pack' ) ];
    }
    return $slider_options;
}


/**
 * helper functions class for helping some common usage things
 */
if (!class_exists('element_pack_helper')) {
    class element_pack_helper {

        static $selfClosing = ['input'];

        /**
         * Renders a tag.
         *
         * @param  string $name
         * @param  array  $attrs
         * @param  string $text
         * @return string
         */
        public static function tag($name, array $attrs = [], $text = null) {
            $attrs = self::attrs($attrs);
            return "<{$name}{ $attrs }" . (in_array($name, self::$selfClosing) ? '/>' : ">$text</{$name}>");
        }

        /**
         * Renders a form tag.
         *
         * @param  array $tags
         * @param  array $attrs
         * @return string
         */
        public static function form($tags, array $attrs = []) {
            $attrs = self::attrs($attrs);
            return "<form{$attrs}>\n" . implode("\n", array_map(function($tag) {
                $output = self::tag($tag['tag'], array_diff_key($tag, ['tag' => null]));
                return $output;
            }, $tags)) . "\n</form>";
        }

        /**
         * Renders an image tag.
         *
         * @param  array|string $url
         * @param  array        $attrs
         * @return string
         */
        public static function image($url, array $attrs = []) {
            $url = (array) $url;
            $path = array_shift($url);
            $params = $url ? '?'.http_build_query(array_map(function ($value) {
                return is_array($value) ? implode(',', $value) : $value;
            }, $url)) : '';

            if (!isset($attrs['alt']) || empty($attrs['alt'])) {
                $attrs['alt'] = true;
            }

            $output = self::attrs(['src' => $path.$params], $attrs);

            return "<img{$output}>";
        }
        
        /**
         * Renders tag attributes.
         * @param  array $attrs
         * @return string
         */
        public static function attrs(array $attrs) {
            $output = [];

            if (count($args = func_get_args()) > 1) {
                $attrs = call_user_func_array('array_merge_recursive', $args);
            }

            foreach ($attrs as $key => $value) {

                if (is_array($value)) { $value = implode(' ', array_filter($value)); }
                if (empty($value) && !is_numeric($value)) { continue; }

                if (is_numeric($key)) {
                   $output[] = $value;
                } elseif ($value === true) {
                   $output[] = $key;
                } elseif ($value !== '') {
                   $output[] = sprintf('%s="%s"', $key, htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false));
                }
            }

            return $output ? ' '.implode(' ', $output) : '';
        }

        /**
         * social icon generator from link
         * @param  [type] $link [description]
         * @return [type]       [description]
         */
        public static function icon($link) {
           static $icons;
           $icons = self::social_icons();

           if (strpos($link, 'mailto:') === 0) {
               return 'mail';
           }

           $icon = parse_url($link, PHP_URL_HOST);
           $icon = preg_replace('/.*?(plus\.google|[^\.]+)\.[^\.]+$/i', '$1', $icon);
           $icon = str_replace('plus.google', 'google-plus', $icon);

           if (!in_array($icon, $icons)) {
               $icon = 'social';
           }

           return $icon;
        }

        // most used social icons array
        public static function social_icons() {
           $icons = [ "behance", "dribbble", "facebook", "github-alt", "github", "foursquare", "tumblr", "whatsapp", "soundcloud", "flickr", "google-plus", "google", "linkedin", "vimeo", "instagram", "joomla", "pagekit", "pinterest", "twitter", "uikit", "wordpress", "xing", "youtube" ];

           return $icons;
        }


        public static function remove_p( $content ) {
            $content = force_balance_tags( $content );
            $content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
            $content = preg_replace( '~\s?<p>(\s| )+</p>\s?~', '', $content );
            return $content;
        }

        /**
         * Get timezone id from server
         * @return [type] [description]
         */
        public static function get_timezone_id() {    
            $timezone = get_option( 'timezone_string' );

            /* If site timezone string exists, return it */
            if ( $timezone ) {
                return $timezone;
            }

            $utc_offset = 3600 * get_option( 'gmt_offset', 0 );

            /* Get UTC offset, if it isn't set return UTC */
            if ( ! $utc_offset ) {
                return 'UTC';
            }

            /* Attempt to guess the timezone string from the UTC offset */
            $timezone = timezone_name_from_abbr( '', $utc_offset );

            /* Last try, guess timezone string manually */
            if ( $timezone === false ) {

                $is_dst = date( 'I' );

                foreach ( timezone_abbreviations_list() as $abbr ) {
                    foreach ( $abbr as $city ) {
                        if ( $city['dst'] == $is_dst && $city['offset'] == $utc_offset ) {
                            return $city['timezone_id'];
                        }
                    }
                }
            }

            /* If we still haven't figured out the timezone, fall back to UTC */
            return 'UTC';
        }

        /**
         * ACtual CSS Class extrator
         * @param  [type] $classes [description]
         * @return [type]          [description]
         */
        public static function acssc($classes) {
            if (is_array($classes)) {
                $classes     = implode($classes, ' ');
            }
            $abs_classes = trim(preg_replace('/\s\s+/', ' ', $classes));
            return $abs_classes;
        }

        /**
         * Custom Excerpt Length
         * @param  integer $limit [description]
         * @return [type]         [description]
         */
        public static function custom_excerpt($limit=50) {
            return strip_shortcodes(wp_trim_words(get_the_content(), $limit, '...'));
        }

    }
}