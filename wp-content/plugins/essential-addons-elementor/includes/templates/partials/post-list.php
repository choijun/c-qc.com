<?php
    /**
     * Post Style List Markup
     */
    if( $post_args['post_style'] == 'list' ) : 
        /**
         * Featured Post Markup
         */
        if( $post_args['eael_post_list_featured_area'] == 'yes' ) : 
            if( isset( $post_args['featured_posts'] ) && ! empty( $post_args['featured_posts'] ) && $feature_counter == 0 ) : 
                $feature_counter++;
                $feature_post = get_post( intval( $post_args['featured_posts'] ) );
                setup_postdata( $feature_post );
                
        ?>
        <div class="eael-post-list-featured-wrap">
            <div class="eael-post-list-featured-inner" style="background-image: url('<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), 'full')); ?>')">
                <div class="featured-content">
                    <?php if( $post_args['eael_post_list_featured_meta'] === 'yes' ) : ?>
                    <div class="meta">
                        <span><i class="fa fa-user"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta ( 'user_nicename' ) ); ?>"><?php the_author(); ?></a></span>
                        <span><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if( $post_args['eael_post_list_featured_title'] === 'yes' ) : ?>
                        <h2 class="eael-post-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php endif; ?>
                    <?php if( $post_args['eael_post_list_featured_excerpt'] === 'yes' ) : ?>
                    <p><?php echo eael_get_excerpt_by_id( get_the_ID(), $post_args['eael_post_list_featured_excerpt_length'] ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
            $isPrinted = true;
            endif; // in_array( get_the_ID(), $post_args['featured_posts'] ) && $feature_counter == 0
        endif; // $post_args['eael_post_list_featured_area'] == 'yes'
        /**
         * Normal Post Markup
         */
        if( ! $isPrinted ) : 
            echo $iterator == 0 ? '<div class="eael-post-list-posts-wrap">' : '';
    ?>
        <div class="eael-post-list-post" >
            <?php if( isset( $post_args['eael_post_list_post_feature_image'] ) && $post_args['eael_post_list_post_feature_image'] === 'yes' ) : ?>
            <div class="eael-post-list-thumbnail<?php if( empty( wp_get_attachment_image_url(get_post_thumbnail_id() ) ) ) : ?> eael-empty-thumbnail<?php endif; ?>"><?php if( !empty( wp_get_attachment_image_url(get_post_thumbnail_id() ) ) ) : ?><img src="<?php echo esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), 'full')); ?>" alt="<?php the_title(); ?>"><?php endif; ?></div> <?php endif; ?>
            <div class="eael-post-list-content">
                <?php if( $post_args['eael_post_list_post_title'] === 'yes' ) : ?>
                <h2 class="eael-post-list-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php endif; ?>
                <?php if( isset( $post_args['eael_post_list_post_meta'] ) && $post_args['eael_post_list_post_meta'] === 'yes' ) : ?>
                <div class="meta">
                    <span><?php echo get_the_date(); ?></span>
                </div>
                <?php endif; ?>
                <?php if( isset( $post_args['eael_post_list_post_excerpt'] ) && $post_args['eael_post_list_post_excerpt'] === 'yes' ) : ?>
                <p><?php echo eael_get_excerpt_by_id( get_the_ID(), $post_args['eael_post_list_post_excerpt_length'] ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php   
            echo ( $iterator == ( $posts->found_posts - 1 ) ) == true ? '</div>' : '';
            $iterator++;
        endif; //  ! $isPrinted 
    endif; // $post_args['post_style'] == 'list'