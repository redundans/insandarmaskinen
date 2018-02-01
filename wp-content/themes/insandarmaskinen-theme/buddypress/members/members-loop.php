<?php
/**
 * BuddyPress - Members Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php if ( bp_has_members( bp_ajax_querystring( 'members' ) ) ) : ?>

	<?php

	/**
	 * Fires before the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_directory_members_list' ); ?>

	<table id="members-list" class="item-list table members" aria-live="assertive" aria-relevant="all">
		<thead>
			<tr>
				<th scope="col" colspan="2"><?php bp_members_pagination_count(); ?></th>
				<th class="text-right pagi"><?php bp_members_pagination_links(); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php while ( bp_members() ) : bp_the_member(); ?>
			<tr>
				<th scope="col">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
				</th>
				<td class="name">
					<h5 class="mb-0">
						<a href="<?php bp_member_permalink(); ?>">
							<?php bp_member_name(); ?>
						</a>
					</h5>
					<small><?php bp_member_last_active(); ?></small>
				</td>
				<td class="medals text-right">
					<?php the_medals( bp_get_member_user_id() ); ?>
					<?php do_action( 'bp_directory_members_item' ); ?>
				</td>
				<!--<td class="text-center">
					<?php do_action( 'bp_directory_members_actions' ); ?>
				</td>-->
	<?php endwhile; ?>
		</tbody>
		<tfoot>
			<tr>
				<th scope="col" colspan="2"><?php bp_members_pagination_count(); ?></th>
				<th class="text-right pagi"><?php bp_members_pagination_links(); ?></th>
			</tr>
		</tfoot>

	</table>

	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_members_loop' );
