<?php

/* Meta boxes */

function sky_settings(){
	add_meta_box("et_post_meta", "Page Settings", "sky_display_options", "page", "normal", "high");
}
add_action("admin_init", "sky_settings");

function sky_display_options($callback_args) {
	global $post;

	$post_type = $callback_args->post_type;
	$temp_array = array();

	$temp_array = maybe_unserialize(get_post_meta($post->ID,'_et_sky_settings',true));

	$et_page_description = get_post_meta( $post->ID, 'Description', true ) ? get_post_meta( $post->ID, 'Description', true ) : '';
	$et_gallery_images_per_page = isset( $temp_array['et_gallery_images_per_page'] ) ? (int) $temp_array['et_gallery_images_per_page'] : 6;

	wp_nonce_field( basename( __FILE__ ), 'et_settings_nonce' );
?>

	<div id="et_custom_settings" style="margin: 13px 0 17px 4px;">
		<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">
			<label for="et_page_description" style="color: #000; font-weight: bold;"> Page Description: </label>
			<input type="text" style="width: 30em;" value="<?php echo esc_attr($et_page_description); ?>" id="et_page_description" name="et_page_description" size="67" />
			<br />
			<small style="position: relative; top: 8px;">Setup the description, located below the page title</small>
		</div>

		<div class="et_fs_setting" style="margin: 13px 0 26px 4px;">
			<label for="et_gallery_images_per_page" style="color: #000; font-weight: bold;"> Number of images per page: </label>
			<input type="text" value="<?php echo esc_attr($et_gallery_images_per_page); ?>" id="et_gallery_images_per_page" name="et_gallery_images_per_page" size="5" />
			<br />
			<small style="position: relative; top: 8px;"> You can setup the number of images per page, if Projects page template is used</small>
		</div>
	</div> <!-- #et_custom_settings -->

	<?php
}

add_action( 'save_post', 'sky_save_details', 10, 2 );
function sky_save_details( $post_id, $post ){
	global $pagenow;
	if ( 'post.php' != $pagenow ) return $post_id;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	if ( !isset( $_POST['et_settings_nonce'] ) || ! wp_verify_nonce( $_POST['et_settings_nonce'], basename( __FILE__ ) ) )
        return $post_id;

	$temp_array = array();

	$temp_array['et_gallery_images_per_page'] = isset($_POST["et_gallery_images_per_page"]) ? (int) $_POST["et_gallery_images_per_page"] : 6;
	update_post_meta( $post_id, "_et_sky_settings", $temp_array );

	update_post_meta( $post_id, "Description", esc_html( $_POST["et_page_description"] ) );
}

add_action( 'admin_enqueue_scripts', 'sky_metabox_upload_scripts' );
function sky_metabox_upload_scripts( $hook_suffix ) {
	if ( 'post.php' == $hook_suffix || 'post-new.php' == $hook_suffix ) {
		wp_register_script('et_admin_delete_full_width_option', get_template_directory_uri().'/js/et_admin_delete_fullwidth.js', array('jquery'));
		wp_enqueue_script('et_admin_delete_full_width_option');
	}
}