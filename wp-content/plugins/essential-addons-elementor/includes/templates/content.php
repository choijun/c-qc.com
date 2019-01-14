<?php

if( isset( $post_args['post_style'] ) ) {

    include('partials/content-ticker.php');
    include('partials/post-timeline.php');

    include('partials/post-carousel.php');
    
    include('partials/content-timeline.php');
    include('partials/dynamic-gallery.php');

    /**
     * Post Block Markup
     */
    if( $post_args['post_style'] == 'block' ) :
        include( 'partials/post-block-style-default.php');
        include( 'partials/post-block-style-overlay.php');
    endif; // $post_args['post_style'] == 'block'
    
    include('partials/post-list.php');
    
}// isset( $post_args['post_style'] )