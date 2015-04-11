<?php
/*
Template Name: Projects Page
*/
?>
<?php get_header(); ?>

<?php
	$et_sky_settings = maybe_unserialize( get_post_meta($post->ID,'_et_sky_settings',true) );
	$et_images_per_page = isset( $et_sky_settings['et_gallery_images_per_page'] ) ? (int) $et_sky_settings['et_gallery_images_per_page'] : 6;
?>

<div id="projects_container" class="clearfix">
	<?php
		$projects_page = isset( $_GET['projects_page'] ) ? (int) $_GET['projects_page'] : 1;
		$projects_offset = 1 != $projects_page ? ( $projects_page - 1 ) * $et_images_per_page : 0;

		$all_images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => -1, 'order'=> 'ASC', 'orderby' => 'menu_order' ) );
		$all_images_count = $all_images ? count( $all_images ) : 0;

		$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'numberposts' => $et_images_per_page, 'order'=> 'ASC', 'orderby' => 'menu_order', 'offset' => $projects_offset ) );

		if ( $images ) {
			foreach ( $images as $image ){
				$gallery_image_info = wp_get_attachment_image_src( $image->ID, 'full' );
				$gallery_image = $gallery_image_info[0];

				$gallery_image_alt = get_post_meta($image->ID, '_wp_attachment_image_alt', true) ? trim(strip_tags( get_post_meta($image->ID, '_wp_attachment_image_alt', true) )) : trim(strip_tags( $image->post_title ));

				echo '<div class="project_entry et_shadow">';
					echo '<div class="project_entry_content">';
						echo '<a href="'.$gallery_image.'" title="'.$gallery_image_alt.'" class="fancybox" rel="single-gallery">' . et_new_thumb_resize( et_multisite_thumbnail($gallery_image), 249, 145 ) . '<span class="overlay"></span> <span class="magnify"></span><span class="title">' . trim( strip_tags( $image->post_title ) ) . '</span></a>';
					echo '</div> <!-- end .project_entry_content -->';
				echo '</div> <!-- end .project_entry -->';
			}

			$et_page_num = floor( $all_images_count / $et_images_per_page ) + 1;
			if ( $all_images_count == $et_images_per_page ) $et_page_num = 1;

			if ( $et_page_num > 1 ){
				echo '<div class="wp-pagenavi">';
					echo '<span class="pages">' . 'Page ' . $projects_page . ' of ' . $et_page_num . '</span>';
					for ( $i = 1; $i <= $et_page_num; $i++ ){
						if ( $i == $projects_page ) echo '<span class="current">' . $i . '</span>';
						else echo '<a href="' . add_query_arg( array( 'projects_page' => $i ), get_permalink() ) . '">' . $i . '</a>';
					}
				echo '</div> <!-- end .wp-pagenavi -->';
			}
		}
	?>
</div> <!-- end #projects_container -->
<?php get_footer(); ?>