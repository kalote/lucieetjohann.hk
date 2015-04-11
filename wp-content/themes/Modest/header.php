<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php elegant_titles(); ?></title>
<?php elegant_description(); ?>
<?php elegant_keywords(); ?>
<?php elegant_canonical(); ?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:regular,bold' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Goudy+Bookletter+1911' rel='stylesheet' type='text/css' />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie6style.css" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, #et-social-icons img, span.overlay, .gotoslide span, #featured .description, .featured-title, .footer-widget ul li, #footer-top, span#down-arrow, .thumb .zoom-icon, span.post-overlay, .avatar-overlay');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie7style.css" />
<![endif]-->
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie8style.css" />
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<div class="right-shadow">
		<div class="left-shadow">
			<div class="container clearfix<?php global $fullwidth; if ( is_page_template('page-full.php') || $fullwidth ) echo '  fullwidth'; ?>">
				<div id="header" class="clearfix">
					<?php
						global $default_colorscheme;
						$logo_additional_path = get_option('modest_color_scheme') <> $default_colorscheme ? 'black/' : '';
					?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('modest_logo') <> '') ? get_option('modest_logo') : get_template_directory_uri().'/images/'.$logo_additional_path.'logo.png'; ?>
						<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" id="logo"/>
					</a>
					<?php $menuClass = 'nav';
					$menuID = 'top-menu';
					$primaryNav = '';
					if (function_exists('wp_nav_menu')) {
						$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
					};
					if ($primaryNav == '') { ?>
						<ul id="<?php echo esc_attr( $menuID ); ?>" class="<?php echo esc_attr( $menuClass ); ?>">
							<?php if (get_option('modest_home_link') == 'on') { ?>
								<li <?php if (is_home()) echo('class="current_page_item"') ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home','Modest') ?></a></li>
							<?php } ?>

							<?php show_page_menu($menuClass,false,false); ?>
							<?php show_categories_menu($menuClass,false); ?>
						</ul> <!-- end ul#nav -->
					<?php }	else echo($primaryNav); ?>

					<div id="icons">
						<span><?php echo esc_html(get_option('modest_header_tagline')); ?></span>
						<div id="et-social-icons">
							 <?php
								$et_rss_url = get_option('modest_rss_url') <> '' ? get_option('modest_rss_url') : get_bloginfo('rss2_url');
								if ( get_option('modest_show_twitter_icon') == 'on' ) $social_icons['twitter'] = array('image' => get_template_directory_uri() . '/images/twitter.png', 'url' => get_option('modest_twitter_url'), 'alt' => 'Twitter' );
								if ( get_option('modest_show_rss_icon') == 'on' ) $social_icons['rss'] = array('image' => get_template_directory_uri() . '/images/rss.png', 'url' => $et_rss_url, 'alt' => 'Rss' );
								if ( get_option('modest_show_facebook_icon') == 'on' ) $social_icons['facebook'] = array('image' => get_template_directory_uri() . '/images/facebook.png', 'url' => get_option('modest_facebook_url'), 'alt' => 'Facebook' );
								$social_icons = apply_filters('et_social_icons', $social_icons);

								if (count($social_icons) > 0) {
                           foreach ($social_icons as $icon) {
                              echo "<a href='" . esc_url($icon['url']) . "' target='_blank'><img alt='" . esc_attr($icon['alt']) . "' src='" . esc_attr($icon['image']) . "' /></a>";
                           }
                        }
							?>
						</div>
					</div>
				</div> <!-- end #header -->

				<?php do_action('et_header'); ?>

				<div id="content-area" class="clearfix">