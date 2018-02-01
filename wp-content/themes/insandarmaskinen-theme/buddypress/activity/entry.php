<?php
/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of an activity entry.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_activity_entry' ); ?>

<tr id="activity-<?php bp_activity_id(); ?>">
	<th>
			<?php
			if ( 'insandare_published' == get_activity_type( bp_get_activity_id() ) ) {
				echo "<img class='published' src='" . get_template_directory_uri() . "/dist/assets/images/001-arrow.svg'>";
			} else if ( 'new_insandare' == get_activity_type( bp_get_activity_id() ) ) {
				echo "<img class='paper' src='" . get_template_directory_uri() . "/dist/assets/images/newspaper-color.svg'>";
			} else if ( 'reported_publications_medal' == get_activity_type( bp_get_activity_id() ) ) {
				echo "<img class='like' src='" . get_template_directory_uri() . "/dist/assets/images/medals/like.svg'>";
			} else if ( 'user_publications_medal' == get_activity_type( bp_get_activity_id() ) ) {
				echo "<img class='like' src='" . get_template_directory_uri() . "/dist/assets/images/medals/003-medal-3.svg'>";
			} else if ( 'reported_post_publications_medal' == get_activity_type( bp_get_activity_id() ) ) {
				echo "<img class='like' src='" . get_template_directory_uri() . "/dist/assets/images/medals/trophy.svg'>";
			} else {
				bp_activity_avatar();
			}
			?>
	</th>
	<td>
		<h5><?php bp_activity_action(); ?></h5>
		<small><?php echo 'För ' . human_time_diff( strtotime( bp_get_activity_date_recorded(), current_time('timestamp') ) ) . ' sedan';  ?></small>
	</td>
	<td>
	</td>
</tr>

<?php

/**
 * Fires after the display of an activity entry.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_activity_entry' );
