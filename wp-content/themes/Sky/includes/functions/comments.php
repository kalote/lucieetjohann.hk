<?php if ( ! function_exists( 'et_custom_comments_display' ) ) :
function et_custom_comments_display($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div class="comment-body">
		   <div id="comment-<?php comment_ID(); ?>" class="clearfix">
				<div class="avatar-box">
					<?php echo get_avatar($comment,$size='80'); ?>
					<span class="avatar-overlay"></span>

					<span class="comment_date"><?php comment_date( get_option( 'sky_comment_date_format' ) ); ?></span>
				</div> <!-- end .avatar-box -->
				<div class="comment-wrap clearfix">
					<div class="comment-meta commentmetadata">
						<?php printf( __('Posted by <span class="fn">%s</span>','Sky'), get_comment_author_link() ); ?>
					</div><!-- .comment-meta .commentmetadata -->

					<?php if ($comment->comment_approved == '0') : ?>
						<em class="moderation"><?php esc_html_e('Your comment is awaiting moderation.','Sky') ?></em>
						<br />
					<?php endif; ?>

					<div class="comment-content"><?php comment_text() ?></div> <!-- end comment-content-->
					<?php
						$et_comment_reply_link = get_comment_reply_link( array_merge( $args, array('reply_text' => esc_attr__('Reply','Sky'),'depth' => $depth, 'max_depth' => $args['max_depth'])) );
						if ( $et_comment_reply_link ) echo '<div class="reply-container">' . $et_comment_reply_link . '</div>';
					?>
				</div> <!-- end comment-wrap-->
			</div> <!-- end comment-body-->
		</div> <!-- end comment-body-->
<?php }
endif; ?>