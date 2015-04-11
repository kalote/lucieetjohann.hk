<div id="featured">
	<?php
		$i=1;

		$featured_cat = get_option('modest_feat_cat');
		$featured_num = (int) get_option('modest_featured_num');
		$width = 462;
		$height = 306;

		if (get_option('modest_use_pages') == 'false') query_posts("posts_per_page=$featured_num&cat=".get_catId($featured_cat));
		else {
			global $pages_number;

			if (get_option('modest_feat_pages') <> '') $featured_num = count(get_option('modest_feat_pages'));
			else $featured_num = $pages_number;

			$et_featured_pages_args = array(
				'post_type' => 'page',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'posts_per_page' => (int) $featured_num,
			);

			if ( is_array( et_get_option( 'modest_feat_pages', '', 'page' ) ) )
				$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'modest_feat_pages', '', 'page' ) );

			query_posts( $et_featured_pages_args );
		}

		while (have_posts()) : the_post();
			$et_link = get_post_meta(get_the_ID(),'Link',true) ? get_post_meta(get_the_ID(),'Link',true) : get_permalink();

			$et_slide_class = '';
			if ( $i == 1 ) $et_slide_class = ' active-block';
			if ( $i == 2 ) $et_slide_class = ' next-block';
			if ( $i == $featured_num ) $et_slide_class = ' prev-block';
		?>
			<div class="slide<?php echo $et_slide_class; ?>">
				<a href="<?php echo $et_link; ?>" class="main">
					<?php
						$post_title = get_the_title();

						$thumbnail = get_thumbnail($width,$height,'thumb',$post_title,$post_title);
						$thumb = $thumbnail["thumb"];

						print_thumbnail($thumb, $thumbnail["use_timthumb"], $post_title, $width, $height, 'Featured');
					?>
				</a>

				<h2 class="featured-title"><?php the_title(); ?></h2>
				<div class="description">
					<p><?php truncate_post(245); ?></p>
				</div> <!-- end .description -->

				<div class="shadow-left"></div>
				<div class="shadow-right"></div>
				<a class="featured-link" href="<?php echo esc_url($et_link); ?>"><?php esc_html_e('Read more','Modest'); ?></a>

				<img src="<?php echo get_template_directory_uri(); ?>/images/active-bottom-shadow.png" alt="" class="bottom-shadow" />
				<a href="#" class="gotoslide"><span></span></a>
			</div> <!-- end .slide -->
	<?php
			$i++;
		endwhile; wp_reset_query();
	?>
</div> <!-- end #featured -->