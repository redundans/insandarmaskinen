<?php

do_action( 'bp_before_group_forum_content' );

if ( bp_is_group_forum_topic_edit() ) :
	locate_template( array( 'groups/single/forum/edit.php' ), true );

elseif ( bp_is_group_forum_topic() ) :
	locate_template( array( 'groups/single/forum/topic.php' ), true );

else : ?>


	<div class="page-header">
		 <h1>Forum</h1>
	</div>

	<div class="item-list-tabs no-ajax" id="subnav" role="navigation">

			<?php if ( is_user_logged_in() ) : ?>

				<a href="#post-new" class="show-hide-new btn"><?php _e( 'New Topic', 'buddypress' ); ?></a>

			<?php endif; ?>

			<?php do_action( 'bp_forums_directory_group_sub_types' ); ?>
			
	</div>

	<div class="forums single-forum" role="main">

		<?php locate_template( array( 'forums/forums-loop.php' ), true ); ?>

	</div><!-- .forums.single-forum -->

<?php endif; ?>

<?php do_action( 'bp_after_group_forum_content' ); ?>

<?php if ( !bp_is_group_forum_topic_edit() && !bp_is_group_forum_topic() ) : ?>

	<?php if ( !bp_group_is_user_banned() && ( ( is_user_logged_in() && 'public' == bp_get_group_status() ) || bp_group_is_member() ) ) : ?>

		<form action="" method="post" id="forum-topic-form" class="standard-form">
			<div id="new-topic-post">

				<?php do_action( 'bp_before_group_forum_post_new' ); ?>

				<?php if ( bp_groups_auto_join() && !bp_group_is_member() ) : ?>
					<p><?php _e( 'You will auto join this group when you start a new topic.', 'buddypress' ); ?></p>
				<?php endif; ?>

				<p id="post-new"></p>
				<h4><?php _e( 'Post a New Topic:', 'buddypress' ); ?></h4>

				<input type="text" name="topic_title" id="topic_title" value="" maxlength="100" placeholder="<?php _e( 'Title:', 'buddypress' ); ?>" />

				<textarea name="topic_text" class="span9" rows="6" id="topic_text" placeholder="<?php _e( 'Content:', 'buddypress' ); ?>"></textarea>

				<input type="text" name="topic_tags" id="topic_tags" value="" placeholder="<?php _e( 'Tags (comma separated):', 'buddypress' ); ?>" />

				<?php do_action( 'bp_after_group_forum_post_new' ); ?>

				<div class="submit">
					<input type="submit" class="btn" name="submit_topic" id="submit" value="<?php _e( 'Post Topic', 'buddypress' ); ?>" />
				</div>

				<?php wp_nonce_field( 'bp_forums_new_topic' ); ?>
			</div><!-- #new-topic-post -->
		</form><!-- #forum-topic-form -->

	<?php endif; ?>

<?php endif; ?>

