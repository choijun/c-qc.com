<?php if( $post_args['post_style'] == 'ticker' ) :  ?>
    <div class="swiper-slide">
        <div class="ticker-content">
            <a href="<?php the_permalink(); ?>" class="ticker-content-link"><?php the_title(); ?></a>
        </div>
    </div>
<?php endif; // $post_args['post_style'] == 'ticker' ?>