			</div> <!-- end #content-area -->
		</div> <!-- end .container -->

		<?php if ( is_home() && get_option('modest_blog_style') == 'false' && get_option('modest_footer_quote') == 'on' ) { ?>
			<div id="call-to-action">
				<div class="container">
					<p><?php echo get_option('modest_footer_quote_text'); ?>
						<a href="<?php echo esc_url(get_option('modest_footer_quote_url')); ?>" class="learn-more"><span><?php esc_html_e('Learn More','Modest'); ?></span></a>
					</p>
					<span id="down-arrow"></span>
				</div> <!-- end .container -->
			</div> <!-- end #call-to-action -->
		<?php } ?>
	</div> <!-- end .left-shadow -->
</div> <!-- end .right-shadow -->

<div id="footer">
	<div class="right-shadow">
		<div class="left-shadow">
			<div id="footer-top">
				<div class="container">
					<div id="footer-widgets" class="clearfix">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
						<?php endif; ?>
					</div> <!-- end #footer-widgets -->

					<div id="footer-bottom" class="clearfix">
						<?php $menuClass = 'bottom-nav';
						$footerNav = '';

						if (function_exists('wp_nav_menu')) $footerNav = wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'echo' => false, 'depth' => '1' ) );
						if ($footerNav == '') show_page_menu($menuClass);
						else echo($footerNav); ?>

						<p id="copyright"><?php esc_html_e('Designed by','Modest'); ?> <a href="http://www.elegantthemes.com">Elegant WordPress Themes</a> | <?php esc_html_e('Powered by', 'Modest'); ?> <a href="http://www.wordpress.org">WordPress</a></p>
					</div> <!-- end #footer-bottom -->
				</div> <!-- end .container -->
			</div> <!-- end #footer-top -->
		</div> <!-- end .left-shadow -->
	</div> <!-- end .right-shadow -->
</div> <!-- end #footer -->

<?php get_template_part('includes/scripts'); ?>
<?php wp_footer(); ?>

</body>
</html>