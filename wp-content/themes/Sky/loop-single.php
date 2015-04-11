<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<div class="single_container et_shadow">
		<div class="single_content">
			<div class="entry post clearfix">
				<?php if (get_option('sky_integration_single_top') <> '' && get_option('sky_integrate_singletop_enable') == 'on') echo(get_option('sky_integration_single_top')); ?>

				<?php
					$thumb = '';
					$width = 200;
					$height = 200;
					$classtext = 'post-thumb';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Single');
					$thumb = $thumbnail["thumb"];
				?>
				<?php if ( $thumb <> '' && get_option( 'sky_thumbnails' ) == 'on' ) { ?>
					<div class="post-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
							<span class="single-post-overlay"></span>
						</a>
					</div> 	<!-- end .post-thumbnail -->
				<?php } ?>

				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','Sky').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php edit_post_link(esc_attr__('Edit this page','Sky')); ?>
			</div> <!-- end .entry -->

			<?php if (get_option('sky_integration_single_bottom') <> '' && get_option('sky_integrate_singlebottom_enable') == 'on') echo(get_option('sky_integration_single_bottom')); ?>

			<?php if (get_option('sky_468_enable') == 'on') { ?>
				<?php
					if(get_option('sky_468_adsense') <> '') echo(get_option('sky_468_adsense'));
					else { ?>
					   <a href="<?php echo esc_url(get_option('sky_468_url')); ?>"><img src="<?php echo esc_attr(get_option('sky_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
			   <?php } ?>
			<?php } ?>
		</div> <!-- end .single_content -->
		<div class="content-bottom"></div>
	</div> <!-- end .single_container -->

	<?php if (get_option('sky_show_postcomments') == 'on') comments_template('', true); ?>
<?php endwhile; // end of the loop. ?>