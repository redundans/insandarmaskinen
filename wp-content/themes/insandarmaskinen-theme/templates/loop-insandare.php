<?php
/**
 * Hero setup.
 *
 * @package understrap
 */

$page = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
$args = array(
	'author' => bp_displayed_user_id(),
	'post_type' => 'insandare',
	'posts_per_page' => 10,
	'paged' => $page,
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) {

?>

	<?php if ( bp_is_user() ) { ?>
	<div class="pagination">	
	<?php
	$big = 999;
	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( '?page='.$big ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('page') ),
		'total' => $the_query->max_num_pages,
		'prev_text' => false,
		'next_text' => false,
		'mid_size' => 1,
	) );
	?>
	</div>
	<?php } ?>

	<table class="table scores">

		<?php if ( ! bp_is_page() && ! bp_is_user() ) { ?>

		<thead>
			<tr>
				<th scope="col" colspan="3">Senaste insändarna</th>
				<th class="text-right">

					<div class="pagination justify-content-end">	
					<?php
					$big = 999;
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( '?page='.$big ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('page') ),
						'total' => $the_query->max_num_pages,
						'prev_text' => false,
						'next_text' => false,
						'mid_size' => 1,
					) );
					?>
					</div>

				</th>
			</tr>
			</thead>
		<tbody>

			<?php } ?>

			<?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
			?>
			<tr>
				<th class="text-left" scope="col">
					<?php
					$reported_post_publications = get_post_meta( get_the_id(), 'reported_post_publications', true ); 
					if ( $reported_post_publications >= 10 ) {
						?><img class="trophy" src="<?php echo get_template_directory_uri(); ?>/dist/assets/images/medals/trophy.svg"><?php
					} else {
						?><img class="paper" src="<?php echo get_template_directory_uri(); ?>/dist/assets/images/newspaper-color.svg"><?php
					}
					?>
				</th>
				<td class="name">
					<h5 class="mb-0">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?></h5>
						</a>
					<small><?php the_date(); ?></small>
				</td>
				<td class="text-center">
					<?php if ( ! bp_is_page() && ! bp_is_user() ) { ?>
					<h5 class="mb-0">
						<a href="<?php echo bp_core_get_user_domain( $the_query->post->post_author ) ?>">
							<?php echo xprofile_get_field_data( 1 ); ?>
						</a>
					</h5>
					<small>Skriven av</small>
					<?php } else {
						?>
						<h5 class="mb-0"><?php echo strlen( get_the_content() ); ?></h5>
						<small>Tecken</small>
						<?php
					} ?>
				</td>
				<td class="text-center">
					<h5 class="mb-0">
						<?php
							$published = wp_get_post_terms( get_the_id(), 'tidningar' );
							echo esc_html( count( $published ) );
						?>
					</h5>
					<small>Publiceringar</small>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>

		<tfoot>
			<tr>
				<th scope="col" colspan="3">Senaste insändarna</th>
				<th class="text-right">

					<div class="pagination justify-content-end">	
					<?php
					$big = 999;
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( '?page='.$big ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('page') ),
						'total' => $the_query->max_num_pages,
						'prev_text' => false,
						'next_text' => false,
						'mid_size' => 1,
					) );
					?>
					</div>

				</th>
			</tr>
		</tfoot>
	</table>
<?php
	wp_reset_postdata();
}
?>
