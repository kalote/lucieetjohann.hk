<?php
/*
Template Name: Login Page
*/
?>
<?php
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta(get_the_ID(),'et_ptemplate_settings',true) );

	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
?>

<?php get_header(); ?>

<div class="single_container et_shadow">
	<div class="single_content">
		<div class="entry post clearfix">
			<?php get_template_part('loop','page'); ?>

			<div id="et-login">
				<div class='et-protected'>
					<div class='et-protected-form'>
						<?php $scheme = apply_filters( 'et_forms_scheme', null ); ?>

						<form action='<?php echo esc_url( home_url( '', $scheme ) ); ?>/wp-login.php' method='post'>
							<p><label><span><?php esc_html_e('Username','Sky'); ?>: </span><input type='text' name='log' id='log' value='<?php echo esc_attr($user_login); ?>' size='20' /><span class='et_protected_icon'></span></label></p>
							<p><label><span><?php esc_html_e('Password','Sky'); ?>: </span><input type='password' name='pwd' id='pwd' size='20' /><span class='et_protected_icon et_protected_password'></span></label></p>
							<input type='submit' name='submit' value='Login' class='etlogin-button' />
						</form>
					</div> <!-- .et-protected-form -->
				</div> <!-- .et-protected -->
			</div> <!-- end #et-login -->

			<div class="clear"></div>
		</div> <!-- end .entry -->
	</div> <!-- end .single_content -->
	<div class="content-bottom"></div>
</div> <!-- end .single_container -->

<?php if (get_option('sky_show_pagescomments') == 'on') comments_template('', true); ?>

<?php get_footer(); ?>