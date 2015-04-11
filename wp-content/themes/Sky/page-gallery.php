<?php
/*
Template Name: Gallery Page
*/
?>
<?php
$et_ptemplate_settings = array();
$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : (bool) $et_ptemplate_settings['et_fullwidthpage'];

$gallery_cats = isset( $et_ptemplate_settings['et_ptemplate_gallerycats'] ) ? $et_ptemplate_settings['et_ptemplate_gallerycats'] : array();
$et_ptemplate_gallery_perpage = isset( $et_ptemplate_settings['et_ptemplate_gallery_perpage'] ) ? (int) $et_ptemplate_settings['et_ptemplate_gallery_perpage'] : 12;
?>

<?php get_header(); ?>

<div class="single_container et_shadow">
	<div class="single_content">
		<div class="entry post clearfix">
			<?php get_template_part('loop','page'); ?>

			<div id="et_pt_gallery" class="clearfix">
				<?php $gallery_query = '';
				if ( !empty($gallery_cats) ) $gallery_query = '&cat=' . implode(",", $gallery_cats);
				else echo '<!-- gallery category is not selected -->'; ?>
				<?php
					$et_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
				?>
				<?php query_posts("posts_per_page=$et_ptemplate_gallery_perpage&paged=" . $et_paged . $gallery_query); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php $width = 207;
					$height = 136;
					$titletext = get_the_title();

					$thumbnail = get_thumbnail($width,$height,'portfolio',$titletext,$titletext,true,'Portfolio');
					$thumb = $thumbnail["thumb"]; ?>

					<div class="et_pt_gallery_entry">
						<div class="et_pt_item_image">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, 'portfolio'); ?>
							<span class="overlay"></span>

							<a class="zoom-icon fancybox" title="<?php the_title_attribute(); ?>" rel="gallery" href="<?php echo($thumbnail['fullpath']); ?>"><?php esc_html_e('Zoom in','Sky'); ?></a>
							<a class="more-icon" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','Sky'); ?></a>
						</div> <!-- end .et_pt_item_image -->
					</div> <!-- end .et_pt_gallery_entry -->

				<?php endwhile; ?>
					<div class="page-nav clearfix">
						<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
						else { ?>
							 <?php get_template_part('includes/navigation'); ?>
						<?php } ?>
					</div> <!-- end .entry -->
				<?php else : ?>
					<?php get_template_part('includes/no-results'); ?>
				<?php endif; wp_reset_query(); ?>
			</div> <!-- end #et_pt_gallery -->
		</div> <!-- end .entry -->
	</div> <!-- end .single_content -->
	<div class="content-bottom"></div>
</div> <!-- end .single_container -->

<?php if (get_option('sky_show_pagescomments') == 'on') comments_template('', true); ?>

<?php get_footer(); ?>