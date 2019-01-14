<?php
    /**
     * Post Block Overlay Markup
     */
    if( $post_args['grid_style'] == 'post-block-style-overlay' ) :
    $post_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $post_args['image_size']); 
?>
    <article class="eael-post-block-item eael-post-block-column">
        <div class="eael-post-block-item-holder">
            <div class="eael-post-block-item-holder-inner">

                <?php if(! empty($post_image) && $post_args['eael_show_image'] == 1){ ?>
                <div class="eael-entry-media">
                    <div class="eael-entry-thumbnail">
                    <?php if ($thumbnail_exists = has_post_thumbnail()): ?>
                        <img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), $post_args['image_size']); ?>">
                    <?php endif; ?>
                    </div>
                </div>
                <?php } ?>


                <?php if(
                    $post_args['eael_show_title']
                    || $post_args['eael_show_meta']
                    ||$post_args['eael_show_excerpt']
                ) : ?>
                <div class="eael-entry-wrapper <?php echo($post_args['eael_post_block_hover_animation']); ?>">
                    <header class="eael-entry-header">
                        <?php if($post_args['eael_show_title']){ ?>
                        <h2 class="eael-entry-title"><a class="eael-grid-post-link" href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        <?php } ?>

                        <?php if($post_args['eael_show_meta'] && $post_args['meta_position'] == 'meta-entry-header'){ ?>
                        <div class="eael-entry-meta">
                            <span class="eael-posted-by"><?php the_author_posts_link(); ?></span>
                            <span class="eael-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></span>
                        </div>
                        <?php } ?>
                    </header>

                    <div class="eael-entry-content">
                        <?php if($post_args['eael_show_excerpt']){ ?>
                        <div class="eael-grid-post-excerpt">
                            <p><?php echo  eael_get_excerpt_by_id(get_the_ID(),$post_args['eael_excerpt_length']);?></p>
                        </div>
                        <?php } ?>
                    </div>
                    <?php if($post_args['eael_show_meta'] && $post_args['meta_position'] == 'meta-entry-footer'){ ?>
                    <div class="eael-entry-footer">
                        <div class="eael-author-avatar">
                            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 96 ); ?> </a>
                        </div>
                        <div class="eael-entry-meta">
                            <div class="eael-posted-by"><?php the_author_posts_link(); ?></div>
                            <div class="eael-posted-on"><time datetime="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></time></div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="eael-entry-overlay-ssss">
                        <a href="<?php echo get_permalink(); ?>"></a>
                    </div>
                </div>
            <?php endif; ?>

            </div>
        </div>
    </article>
<?php endif; // $post_args['grid_style'] == 'overlay'