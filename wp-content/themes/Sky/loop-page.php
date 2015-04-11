<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php if (get_option('sky_page_thumbnails') == 'on') { ?>
		<?php
			$thumb = '';
			$width = 200;
			$height = 200;
			$classtext = 'post-thumb';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Single');
			$thumb = $thumbnail["thumb"];
		?>

		<?php if($thumb <> '') { ?>
			<div class="post-thumbnail">
				<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
				<span class="single-post-overlay"></span>
			</div> 	<!-- end .post-thumbnail -->
		<?php } ?>
	<?php } ?>

	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<p><strong>'.esc_attr__('Pages','Sky').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	<?php edit_post_link(esc_attr__('Edit this page','Sky')); ?>
<?php endwhile; // end of the loop. ?>