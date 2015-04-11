(function($){
	$(document).ready(function(){
		var $et_top_menu = $('body.home #top-menu'),
			$et_top_menu_item = $et_top_menu.find('li'),
			et_current_class = 'current_page_item',
			et_current_arrow = 'current-arrow',
			et_page_class = 'menu-item-object-page',
			et_category_class = 'menu-item-object-category',
			et_homelink_class = 'menu-item-home',
			et_is_animated = false,
			et_current_menu_item = 0,
			pagenavi_clicked = false,
			pagenavi_prev = null,
			pagenavi_next = null,
			is_ie = jQuery.browser.msie;

		et_config_scripts( 1 );

		if ( 'on' === et_site_data.enable_ajax ){
			// on index pages: make page links go to homepage, e.g 'http://url.com/my_page/' is replaced with 'http://url.com/#!/my_page/'
			if ( ! $et_top_menu.length ){
				var $index_page_menu = $('#top-menu');
				$index_page_menu.find( 'li.' + et_page_class ).not( '.' + et_current_class ).each( function(){
					var link_href = $(this).find('a').attr('href');
					if ( link_href.indexOf( et_site_data.site_url ) >= 0 ){
						$(this).find('a').attr( 'href', link_href.replace( et_site_data.site_url, et_site_data.site_url + '#!/' ) );
					}
				} );
			}

			$('<div id="et_ajax_info"></div>').css('display','none').appendTo('body');
			var $et_ajax_info = $('#et_ajax_info');

			$et_top_menu_item.find('a').click( et_load_link_with_ajax );
		} else {
			return;
		}

		function et_load_link_with_ajax(){
			$et_this_link = $(this);

			if ( $et_this_link.parent().is('.wp-pagenavi') ){
				pagenavi_clicked = true;

				pagenavi_prev = $('.wp-pagenavi span.current').text();
				pagenavi_next = $et_this_link.text();
			}

			if ( ! ( $et_this_link.parent('li').hasClass( et_page_class ) || $et_this_link.parent('li').hasClass(et_homelink_class) || $et_this_link.parent('li').hasClass(et_category_class) || $et_this_link.parent().is( '.wp-pagenavi' ) || $et_this_link.parents('.slide').length ) ) return;

			if ( ! $et_this_link.parent('li').hasClass( et_current_class ) && ! et_is_animated ){
				et_current_menu_item = $et_this_link.parent('li').prevAll().length;
				$.address.value( $et_this_link.attr('href').replace( et_site_data.site_url, '' ) );

				$et_ajax_info.ajaxStart( function(){
					$(this).css('display','block');
				});

				$et_ajax_info.ajaxStop( function(){
					$et_ajax_info.css('display','none');
				});
			}

			return false;
		}

		$.address.crawlable(true).change(function(event) {
			// top menu with Home link: don't do anything if we just loaded homepage and Home link is active
			if ( event.value && ! ( $et_top_menu.find( 'li.' + et_homelink_class ).hasClass( et_current_class ) && event.value == '/' ) ) {
				if ( event.value == '/' && ! $et_top_menu.find( 'li.' + et_homelink_class ).length ) return; // top menu without Home link: don't do anything if we load homepage
				var et_event_value = '/' === event.value && is_ie ? et_site_data.site_url : event.value.slice(1);
				$.ajax( {
					url: et_event_value,
					context: document.body,
					success: function( data ) {
						et_is_animated = true;

						var et_content_block_name = '#content',
							$et_content = $( et_content_block_name ),
							et_direction = ( $et_top_menu_item.eq( et_current_menu_item ).nextAll( 'li.' + et_current_class ).length ) ? 1 : -1,
							et_switch_menu = true;

						if ( null != pagenavi_prev && null != pagenavi_next ) {
							et_direction = pagenavi_prev < pagenavi_next ? 1 : -1;
							et_switch_menu = false;
							pagenavi_prev = null;
							pagenavi_next = null;
						}

						$et_content.animate( { left: et_direction * 1600 + 'px' }, 700, function(){
							$et_content.remove();

							$('#container').append( $( data ).find( et_content_block_name ).css( { 'left' : -et_direction * 1920 + 'px' } ) );

							// load page templates and shortcodes scripts on each ajax request
							$.getScript( et_site_data.theme_url + '/epanel/page_templates/js/et-ptemplates-frontend.js');

							$('script').each(function(index) {
								// load all scripts, except jquery and the ones inside Sky theme folder
								if ( $(this).attr('src') && -1 === $(this).attr('src').search( 'jquery.js' ) && -1 === $(this).attr('src').search( et_site_data.theme_url ) ){
									$.getScript( $(this).attr('src') );
								}
							});

							et_config_scripts( 0 );
							et_sky_shortcodes_init();

							$( et_content_block_name ).animate( { left: '0' }, 700 );
						} );

						var $et_bg = $('#bg'),
							$et_top_menu_active_link = $et_top_menu_item.find( 'a[href$="' + event.value + '"]'),
							et_bg_offset;

						if ( et_switch_menu ){
							$et_top_menu_item.removeClass( et_current_class ).removeClass( et_current_arrow );

							if ( $et_top_menu_active_link.length == 1 ) $et_top_menu_active_link.parent('li').addClass( et_current_class ).addClass( et_current_arrow );

							if ( event.value == '/' && $et_top_menu.find( 'li.' + et_homelink_class ).length )
								$et_top_menu.find( 'li.' + et_homelink_class ).addClass( et_current_class ).addClass( et_current_arrow );
						}

						if ( is_ie && ( $.browser.version.substr(0,1) < 9 ) ) {
							et_is_animated = false;
						} else {
							et_bg_offset = $et_bg.css( 'backgroundPosition' ).split(' ');
							$et_bg.animate( { backgroundPosition: ( parseInt( et_bg_offset[0] ) + -et_direction * 300 ) + 'px 0' }, 1800, function(){
								et_is_animated = false;
							} );
						}
					}
				} );
			}
		});

		function et_config_slider(){
			var $slider = $('#slider'),
				$featured_content = $slider.find('#slides');

			if ($featured_content.length) {
				var $featured_controllers_links = $slider.find('#controllers li'),
					et_slider_settings = {
						timeout: 0,
						cleartypeNoBg: true,
						before: function (currSlideElement, nextSlideElement, options, forwardFlag) {
							var $et_active_slide = jQuery(nextSlideElement),
								et_active_order = $et_active_slide.prevAll().length;

							$featured_controllers_links.removeClass('active').eq(et_active_order).addClass('active');
						}
					};

				if ( $featured_content.is('.et_slider_auto') ) {
					var et_slider_autospeed_class_value = /et_slider_autospeed_(\d+)/g
						et_slider_autospeed = et_slider_autospeed_class_value.exec( $featured_content.attr('class') );

					et_slider_settings.timeout = et_slider_autospeed[1];
					if ( $featured_content.is('.et_slider_pause') ) et_slider_settings.pause = 1;
				}

				$featured_content.css( 'backgroundImage', 'none' ).cycle( et_slider_settings );

				if ( $featured_content.find('.slide').length == 1 ){
					$featured_content.find('.slide').css({'position':'absolute','top':'20px','left':'20px'}).show();
				}

				$featured_controllers_links.click(function(){
					et_ordernumber = jQuery(this).prevAll().length;
					$featured_content.cycle( et_ordernumber );
					return false;
				})

				$slider.find('#controllers li:first-child').addClass( 'first' );
				$slider.find('#controllers li:last-child').addClass( 'last' );
			}
		}

		function et_config_scripts( et_first_load ){
			var $et_project = $('.project_entry_content a'),
				$et_respond = $('#comment-wrap > #respond'),
				pagenavi_prev = null,
				pagenavi_next = null;

			if ( 1 == et_first_load ) $(window).load( et_config_slider );
			else et_config_slider();

			$et_project.find('span').css( { 'opacity' : '0', 'display' : 'block' } );

			$et_project.hover( function(){
				$(this).find('img').stop(true,true).animate( { opacity : 0.8 }, 500 );
				$(this).find('span').stop(true,true).animate( { opacity : 1 }, 500 );
			}, function(){
				$(this).find('img').stop(true,true).animate( { opacity : 1 }, 500 );
				$(this).find('span').stop(true,true).animate( { opacity : 0 }, 500 ) ;
			} );

			$et_respond.wrap( '<div class="comments_container et_shadow comments_respond" />' ).wrap( '<div class="comments_content" />' );
			$et_respond.parents( '.comments_container' ).append( '<div class="content-bottom"></div>' );

			var $comment_form = jQuery('form#commentform');
			$comment_form.find('input:text, textarea').each(function(index,domEle){
				var $et_current_input = jQuery(domEle),
					$et_comment_label = $et_current_input.siblings('label'),
					et_comment_label_value = $et_current_input.siblings('label').text();
				if ( $et_comment_label.length ) {
					$et_comment_label.hide();
					if ( $et_current_input.siblings('span.required') ) {
						et_comment_label_value += $et_current_input.siblings('span.required').text();
						$et_current_input.siblings('span.required').hide();
					}
					$et_current_input.val(et_comment_label_value);
				}
			}).live('focus',function(){
				var et_label_text = jQuery(this).siblings('label').text();
				if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
				if (jQuery(this).val() === et_label_text) jQuery(this).val("");
			}).live('blur',function(){
				var et_label_text = jQuery(this).siblings('label').text();
				if ( jQuery(this).siblings('span.required').length ) et_label_text += jQuery(this).siblings('span.required').text();
				if (jQuery(this).val() === "") jQuery(this).val( et_label_text );
			});

			// remove placeholder text before form submission
			$comment_form.submit(function(){
				$comment_form.find('input:text, textarea').each(function(index,domEle){
					var $et_current_input = jQuery(domEle),
						$et_comment_label = $et_current_input.siblings('label'),
						et_comment_label_value = $et_current_input.siblings('label').text();

					if ( $et_comment_label.length && $et_comment_label.is(':hidden') ) {
						if ( $et_comment_label.text() == $et_current_input.val() )
							$et_current_input.val( '' );
					}
				});
			});

			pagenavi_clicked = false;

			$('.wp-pagenavi a').click( et_load_link_with_ajax );
			$('#slides .slide a').click( et_load_link_with_ajax );

			// shortcodes init
			$('.et-learn-more').not('.et-open').find('.learn-more-content').css( { 'visibility' : 'visible', 'display' : 'none' } );
		}

		function et_sky_shortcodes_init(){
			var $et_shortcodes_tabs = $('.et-tabs-container, .tabs-left, .et-simple-slider, .et-image-slider');
			$et_shortcodes_tabs.each(function(i){
				var et_shortcodes_tab_class = $(this).attr('class'),
					et_shortcodes_tab_autospeed_class_value = /et_sliderauto_speed_(\d+)/g,
					et_shortcodes_tab_autospeed = et_shortcodes_tab_autospeed_class_value.exec( et_shortcodes_tab_class ),
					et_shortcodes_tab_auto_class_value = /et_sliderauto_(\w+)/g,
					et_shortcodes_tab_auto = et_shortcodes_tab_auto_class_value.exec( et_shortcodes_tab_class ),
					et_shortcodes_tab_type_class_value = /et_slidertype_(\w+)/g,
					et_shortcodes_tab_type = et_shortcodes_tab_type_class_value.exec( et_shortcodes_tab_class ),
					et_shortcodes_tab_fx_class_value = /et_sliderfx_(\w+)/g,
					et_shortcodes_tab_fx = et_shortcodes_tab_fx_class_value.exec( et_shortcodes_tab_class ),
					et_shortcodes_tab_apply_to_element = '.et-tabs-content',
					et_shortcodes_tab_settings = {};

				et_shortcodes_tab_settings.linksNav = $(this).find('.et-tabs-control li a');
				et_shortcodes_tab_settings.findParent = true;
				et_shortcodes_tab_settings.fx = et_shortcodes_tab_fx[1];
				et_shortcodes_tab_settings.auto = 'false' === et_shortcodes_tab_auto[1] ? false : true;
				et_shortcodes_tab_settings.autoSpeed = et_shortcodes_tab_autospeed[1];

				if ( 'top_tabs' === et_shortcodes_tab_type[1] ) {
					et_shortcodes_tab_settings.slidePadding = '20px 25px 8px';
				} else if ( 'simple' === et_shortcodes_tab_type[1] ){
					et_shortcodes_tab_settings = {};
					et_shortcodes_tab_settings.auto = 'false' === et_shortcodes_tab_auto[1] ? false : true;
					et_shortcodes_tab_settings.autoSpeed = et_shortcodes_tab_autospeed[1];
					et_shortcodes_tab_settings.sliderType = 'simple';
					et_shortcodes_tab_settings.useArrows = true;
					et_shortcodes_tab_settings.arrowLeft = $(this).find('a.et-slider-leftarrow');
					et_shortcodes_tab_settings.arrowRight = $(this).find('a.et-slider-rightarrow');
					et_shortcodes_tab_apply_to_element = '.et-simple-slides';
				} else if ( 'images' === et_shortcodes_tab_type[1] ){
					et_shortcodes_tab_settings.sliderType = 'images';
					et_shortcodes_tab_settings.linksNav = '#' + $(this).attr('id') + ' .controllers a.switch';
					et_shortcodes_tab_settings.useArrows = true;
					et_shortcodes_tab_settings.arrowLeft = '#' + $(this).attr('id') + ' a.left-arrow';
					et_shortcodes_tab_settings.arrowRight = '#' + $(this).attr('id') + ' a.right-arrow';;
					et_shortcodes_tab_settings.findParent = false;
					et_shortcodes_tab_settings.lengthElement = '#' + $(this).attr('id') + ' a.switch';
					et_shortcodes_tab_apply_to_element = '.et-image-slides';
				}

				$(this).find(et_shortcodes_tab_apply_to_element).et_shortcodes_switcher( et_shortcodes_tab_settings );
			});

			// learn more
			var $et_learn_more = $('.et-learn-more .heading-more');
			$et_learn_more.click( function() {
				if ( $(this).hasClass('open') )
					$(this).removeClass('open');
				else
					$(this).addClass('open');

				$(this).parent('.et-learn-more').find('.learn-more-content').animate({ opacity: 'toggle', height: 'toggle' }, 300);
			} );

			$('.et-learn-more').not('.et-open').find('.learn-more-content').css( { 'visibility' : 'visible', 'display' : 'none' } );
		}
	});
})(jQuery)