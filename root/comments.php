<?php
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
if ( post_password_required() ) {
	?> <p>Эта статья защищена паролем. Введите пароль, что бы увидеть коментарии.</p> <?php
	return;
}
	
function theme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	
	<li>
		<div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<?php echo get_avatar( $comment, 48 ); ?>
			<p class="meta"><?php comment_date('F d, Y'); ?> в <?php comment_time('H:i'); ?>, <?php comment_author_link(); ?> сказал(а):</p>
			<?php if ($comment->comment_approved == '0') : ?>
			<p>Ваш комментарий ожидает модерации</p>
			<?php else: ?>
			<?php comment_text(); ?>
			<?php endif; ?>
			
			<?php
				comment_reply_link(array_merge( $args, array(
					'reply_text' => 'Reply',
					'before' => '<p>',
					'after' => '</p>',
					'depth' => $depth,
					'max_depth' => $args['max_depth']
				))); ?>
		</div>
	<?php }
	
	function theme_comment_end() { ?>
		</li>
	<?php }
?>

<?php if ( have_comments() ) : ?>
    <div class="section comments" id="comments">
        <ul class="comment-list">
            <?php wp_list_comments(array(
                'callback' => 'theme_comment',
                'end-callback' => 'theme_comment_end'
                )); ?>
        </ul>
        <div class="navigation">
            <div class="next"><?php previous_comments_link('&laquo; Старые Комментарии') ?></div>
            <div class="prev"><?php next_comments_link('Новые Комментарии &raquo;') ?></div>
        </div>
    </div>
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->
	<?php else : // comments are closed ?>
		<!-- If comments are closed. -->
	<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
<div class="section respond" id="respond">
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		<fieldset>
			<h2><?php comment_form_title( 'Оставьте комментарий', 'Оставьте коментарий для %s' ); ?></h2>
	
			<div class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></div>
		
			<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
    			<p>Вы должны <a href="<?php echo wp_login_url( get_permalink() ); ?>">залогинеться</a> для возможности оставлять комментарии.</p>
			<?php else : ?>
			
			<?php if ( is_user_logged_in() ) : ?>
			    <p><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Выйти &raquo;</a></p>
			<?php else : ?>
				<label for="author">Имя</label>
				<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" />
				<label for="email">E-Mail (не опубликовывается)</label>
				<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" />
				<label for="url">Web сайт</label>
				<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" />
			<?php endif; ?>

				<label for="comment">Комметарий</label>
				<textarea name="comment" id="comment" cols="100%" rows="10"></textarea>
				<input name="submit" type="submit" id="submit" value="Отправить" />

			<?php
				comment_id_fields();
				do_action('comment_form', $post->ID);
			?>
			<?php endif; ?>
		</fieldset>
	</form>
</div>
<?php endif; ?>
