<?php get_header(); ?>

<div class="single_container et_shadow">
	<div class="single_content">
		<div class="entry post clearfix">
			<?php get_template_part('loop','page'); ?>
		</div> <!-- end .entry -->
	</div> <!-- end .single_content -->
	<div class="content-bottom"></div>
</div> <!-- end .single_container -->

<?php if (get_option('sky_show_pagescomments') == 'on') comments_template('', true); ?>

<?php get_footer(); ?>