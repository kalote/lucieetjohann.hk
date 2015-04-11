<?php
	$et_page_title = '';
	$et_tagline = '';
	if( is_home() ) {
		$et_page_title = get_option( 'sky_homepage_title' );
		$et_tagline = get_option( 'sky_homepage_tagline' );
	} elseif( is_tag() ) {
		$et_page_title = esc_html__('Posts Tagged &quot;','Sky') . single_tag_title('',false) . '&quot;';
	} elseif (is_day()) {
		$et_page_title = esc_html__('Posts made in','Sky') . ' ' . get_the_time('F jS, Y');
	} elseif (is_month()) {
		$et_page_title = esc_html__('Posts made in','Sky') . ' ' . get_the_time('F, Y');
	} elseif (is_year()) {
		$et_page_title = esc_html__('Posts made in','Sky') . ' ' . get_the_time('Y');
	} elseif (is_search()) {
		$et_page_title = esc_html__('Search results for','Sky') . ' ' . get_search_query();
	} elseif (is_category()) {
		$et_page_title = single_cat_title('',false);
		$et_tagline = category_description();
	} elseif (is_author()) {
		global $wp_query;
		$curauth = $wp_query->get_queried_object();
		$et_page_title = esc_html__('Posts by ','Sky') . $curauth->nickname;
	} elseif ( is_page() ) {
		$et_page_title = get_the_title();
		$et_tagline = get_post_meta($post->ID,'Description',true) ? get_post_meta($post->ID,'Description',true) : '';
	} elseif ( is_single() ){
		$et_page_title = get_the_title();
	}
?>
<h1 id="page-title"><?php echo esc_html( $et_page_title ); ?></h1>
<?php if ( '' != $et_tagline ){ ?>
	<p id="tagline"<?php if ( is_home() && 'on' == get_option('sky_featured') ) echo ' class="featured"'; if ( is_singular() ) echo ' class="singular"'; ?>><span><?php echo esc_html( $et_tagline ); ?></span></p>
<?php } ?>

<?php if ( is_single() ) { ?>
	<?php global $query_string;
	$new_query = new WP_Query($query_string);
	while ($new_query->have_posts()) $new_query->the_post(); ?>
		<?php if ( get_option('sky_postinfo2') ) { ?>
			<p id="tagline" class="singular"><span><?php esc_html_e('Posted','Sky'); ?> <?php if (in_array('author', get_option('sky_postinfo2'))) { ?> <?php esc_html_e('by','Sky'); ?> <?php the_author_posts_link(); ?><?php }; ?><?php if (in_array('categories', get_option('sky_postinfo2'))) { ?> <?php esc_html_e('in','Sky'); ?> <?php the_category(', ') ?><?php }; ?><?php if (in_array('date', get_option('sky_postinfo2'))) { ?> <?php esc_html_e('on','Sky'); ?> <?php the_time(get_option('sky_single_post_date_format')) ?><?php }; ?></span></p>
		<?php } ?>
	<?php wp_reset_postdata() ?>
<?php } ?>