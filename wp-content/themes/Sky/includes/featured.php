<?php
	$et_slider_settings_class = '';
	$et_slider_auto = 'on' == get_option('sky_slider_auto') ? 'et_slider_auto' : '';

	$et_slider_auto_speed = false !== get_option('sky_slider_autospeed') ? get_option('sky_slider_autospeed') : '7000';
	$et_slider_auto_speed = ' et_slider_autospeed_' . $et_slider_auto_speed;

	$et_slider_pause = 'on' == get_option('sky_slider_pause') ? ' et_slider_pause' : '';

	$et_slider_settings_class = $et_slider_auto . $et_slider_auto_speed . $et_slider_pause;
?>
<div id="main-content" class="et_shadow">
	<div id="slider">
		<div id="slides" class="<?php echo esc_attr( $et_slider_settings_class ); ?>">
			<?php
			$arr = array();
			$i=0;

			$featured_cat = get_option('sky_feat_cat');
			$featured_num = get_option('sky_featured_num');
			if ( $featured_num > 4 ) $featured_num = 4;

			if (get_option('sky_use_pages') == 'false') query_posts( "posts_per_page=$featured_num&cat=" . get_catId( $featured_cat ) );
			else {
				global $pages_number;

				if (get_option('sky_feat_pages') <> '') $featured_num = count(get_option('sky_feat_pages'));
				else $featured_num = $pages_number;

				if ( $featured_num > 4 ) $featured_num = 4;

				$et_featured_pages_args = array(
					'post_type' => 'page',
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'posts_per_page' => (int) $featured_num,
				);

				if ( is_array( et_get_option( 'sky_feat_pages', '', 'page' ) ) )
					$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'sky_feat_pages', '', 'page' ) );

				query_posts( $et_featured_pages_args );
			} ?>
			<?php if (have_posts()) : while (have_posts()) : the_post();
			global $post; ?>
				<div class="slide">
					<?php
					$width = 847;
					$height = 309;

					$titletext = get_the_title();

					$thumbnail = get_thumbnail($width,$height,'featured-image',$titletext,$titletext,false,'Featured');

					$arr[$i]['titletext'] = get_post_meta( get_the_ID(), 'Smalltitle', true ) ? get_post_meta( get_the_ID(), 'Smalltitle', true ) : truncate_title(20,false);
					$arr[$i]['description'] = get_post_meta( get_the_ID(), 'Smalldesc', true ) ? get_post_meta( get_the_ID(), 'Smalldesc', true ) : truncate_post(45,false);

					$thumb = $thumbnail["thumb"];
					print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, 'featured-image'); ?>
					<span class="overlay"></span>
					<div class="description">
						<h2 class="featured-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p><?php truncate_post(350); ?></p>
						<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e('Read More', 'Sky'); ?></a>
					</div> <!-- end .description -->
				</div> <!-- end .slide -->
			<?php $i++; endwhile; endif; wp_reset_query(); ?>
		</div> <!-- end #slides -->
		<div id="controllers" class="clearfix">
			<ul>
				<?php for ($i = 0; $i < $featured_num; $i++) { ?>
					<li<?php if ( $i == 0 ) echo ' class="active"'; ?>>
						<div class="controller">
							<h3><?php echo esc_html( $arr[$i]['titletext'] ); ?></h3>
							<p><?php echo esc_html( $arr[$i]['description'] ); ?></p>
						</div>
					</li>
				<?php } ?>
			</ul>
			<div id="left-shadow"></div>
			<div id="right-shadow"></div>
		</div> <!-- end #controllers -->
	</div> <!-- end #slider -->

	<div class="content-bottom"></div>
</div> <!-- end #main-content -->