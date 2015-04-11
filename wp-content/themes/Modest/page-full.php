<?php
/*
Template Name: Full Width Page
*/
?>
<?php get_header(); ?>

	<?php get_template_part('includes/top_info'); ?>

	<div id="left-area">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if (get_option('modest_integration_single_top') <> '' && get_option('modest_integrate_singletop_enable') == 'on') echo(get_option('modest_integration_single_top')); ?>

		<div class="entry clearfix post">
			<?php
				$thumb = '';
				$width = 188;
				$height = 188;
				$classtext = 'post-thumb';
				$titletext = get_the_title();
				$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
				$thumb = $thumbnail["thumb"];
			?>

			<?php if($thumb <> '' && get_option('modest_page_thumbnails') == 'on') { ?>
				<div class="post-thumbnail">
					<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
					<span class="post-overlay"></span>
				</div> 	<!-- end .post-thumbnail -->
			<?php } ?>

			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','Modest').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php edit_post_link(esc_html__('Edit this page','Modest')); ?>
		</div> <!-- end .entry -->

		<?php if (get_option('modest_show_pagescomments') == 'on') comments_template('', true); ?>

		<?php if (get_option('modest_integration_single_bottom') <> '' && get_option('modest_integrate_singlebottom_enable') == 'on') echo(get_option('modest_integration_single_bottom')); ?>
	<?php endwhile; endif; ?>
	</div> 	<!-- end #left-area -->

<?php get_footer(); ?>