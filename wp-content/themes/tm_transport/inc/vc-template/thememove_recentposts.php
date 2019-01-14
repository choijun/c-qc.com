<?php
/**
 * Shortcode attributes
 * @var $type
 * @var $number
 * @var $show_title
 * @var $show_excerpt
 * @var $show_meta
 * @var $hide_comment_meta
 * @var $show_read_more
 * Shortcode class
 * @var $this WPBakeryShortCode_Thememove_Recentposts
 */
$output = '';
$atts   = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$args = array( 'post_type' => 'post', 'posts_per_page' => $number );
$loop = new WP_Query( $args );
?>
<?php if ( $type == 'type_2' ) { ?>
	<div class="recent-posts type_2">
		<div class="row">
			<?php while ( $loop->have_posts() ) : $loop->the_post();
				$meta = get_post_meta( get_the_ID() ); ?>
				<div class="col-md-4">
					<div>
						<div class="post-thumb">
							<div class="dates">
								<span class="month"><?php the_time( 'F' ); ?></span>
								<span class="date"><?php the_time( 'd' ); ?></span>
								<span class="year"><?php the_time( 'Y' ); ?></span>
							</div>
							<?php if ( has_post_thumbnail() ) { ?>
								<?php the_post_thumbnail( array( 370, 220, 'bfi_thumb' => true ) ); ?>
							<?php } else { ?>
								<img src="https://placeholdit.imgix.net/~text?txtsize=35&bg=ca1f26&txtclr=ffffff&txt=370%C3%97220&w=370&h=220" alt="thumbnail">
							<?php } ?>
						</div>
						<?php if ( $show_title ): ?>
							<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
						<?php endif ?>
						<?php if ( $show_meta ): ?>
							<div class="entry-meta">
								<span class="author vcard"><i
										class="fa fa-user"></i> <?php echo __( 'Posted by ', 'infinity' ) . get_the_author(); ?></span>
								<span class="categories-links"><i
										class="fa fa-folder"></i> <?php echo __( 'In ', 'infinity' ) . get_the_category_list( __( ', ', 'infinity' ) ) ?> </span>
								<?php if ( ! $hide_comment_meta ): ?>
									<span class="comments-counts"><i
											class="fa fa-comment"></i><?php comments_number( '0', '1', '%' ); ?> <?php comments_number( 'comment', 'Comment', 'Comments' ); ?></span>
								<?php endif ?>
							</div><!-- .entry-meta -->
						<?php endif ?>
						<?php if ( $show_excerpt ): ?>
							<div class="entry-excerpt"><?php the_excerpt(); ?></div>
						<?php endif ?>
						<?php if ( $show_read_more ): ?>
							<a class="read-more"
							   href="<?php the_permalink() ?>"><?php esc_html_e( 'Read more', 'infinity' ); ?> <i
									class="fa fa-arrow-right"></i></a>
						<?php endif ?>
					</div>
				</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
	</div>
<?php } else { ?>
	<div class="recent-posts type_1">
		<?php while ( $loop->have_posts() ) : $loop->the_post();
			$meta = get_post_meta( get_the_ID() ); ?>
			<div class="recent-posts__item">
				<div class="recent-posts__thumb">
					<a href="<?php the_permalink() ?>">
						<?php if ( has_post_thumbnail() ) { ?>
							<?php the_post_thumbnail( array( 120, 90, 'bfi_thumb' => true ) ); ?>
						<?php } else { ?>
							<img
								src="https://placeholdit.imgix.net/~text?txtsize=20&bg=ca1f26&txtclr=ffffff&txt=120%C3%9790&w=120&h=90"
								alt="thumbnail">
						<?php } ?>
					</a>
				</div>
				<?php if ( $show_title ): ?>
					<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
				<?php endif ?>
				<?php if ( $show_excerpt ): ?>
					<div class="entry-excerpt"><?php the_excerpt(); ?></div>
				<?php endif ?>
				<?php if ( $show_meta ): ?>
					<div class="post-meta">
						<span class="author"><i class="fa fa-user"></i> <?php the_author(); ?></span>
						<span class="post-date"><i class="fa fa-clock-o"></i> <?php the_time( 'F j, Y' ); ?></span>
						<?php if ( ! $hide_comment_meta ): ?>
							<span class="post-com"><i
									class="fa fa-comments"></i> <?php comments_number( 'No response', 'One response', '% responses' ); ?></span>
						<?php endif ?>
					</div>
				<?php endif ?>
				<?php if ( $show_read_more ): ?>
					<a class="read-more" href="<?php the_permalink() ?>"><?php esc_html_e( 'Read more', 'infinity' ); ?>
						<i class="fa fa-arrow-right"></i></a>
				<?php endif ?>
			</div>
		<?php endwhile;
		wp_reset_postdata(); ?>
	</div>
<?php } ?>
