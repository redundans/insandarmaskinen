<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();

?>

<?php if ( is_front_page() || is_home() ) : ?>
	<?php get_template_part( 'templates/hero', 'none' ); ?>
<?php endif; ?>

<div class="wrapper" id="wrapper-index">

	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

			<main class="site-main" id="main">

				<?php
				$monthly_top_users = most_published_author();
				?>

				<table class="table scores">
					<thead>
						<tr>
							<th scope="col" colspan="4">Flest publiceringar i <?php echo  date_i18n( 'F', strtotime( '-1 month -1 day' ) ); ?></th>
						</tr>
					</thead>
					<tbody>

						<?php 
						foreach ( $monthly_top_users as $key => $user ) {
						?>
						<tr>
							<th scope="col">
								<img class="medal" src="<?php echo get_template_directory_uri(); ?>/dist/assets/images/medals/<?php echo ( $key == 0? '003-medal-3.svg' : '009-medal-2.svg'); ?>">
							</th>
							<td class="name">
								<h5 class="mb-0">
									<a href="<?php echo esc_url( $user['post_author_link'] ); ?>">
										<?php echo esc_html( $user['post_author_name'] ); ?></h5>
									</a>
								<small><?php echo esc_html( $user['last_action'] ); ?></small>
							</td>
							<td class="text-center">
								<h5 class="mb-0"><?php echo esc_html( $user['posted'] ); ?></h5>
								<small>Skickade</small>
							</td>
							<td class="text-center">
								<h5 class="mb-0"><?php echo esc_html( $user['published'] ); ?></h5>
								<small>Publicerade</small>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>

			</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->



<div id="wrapper-chart">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 text-center">
				<h1><?php echo wp_count_posts( 'insandare' )->publish; ?>st</h1>
				<div class="chart-content">
					<p>Så många insändare har skickats genom åren med hjälp av <strong>Insändarmaskinen™</strong>. Nedan ser du hur många insändare som skickades under de senaste sex månaderna.</p>
				</div>
			</div>
			<div class="col-md-12">
				<canvas id="myChart" width="400" height="100"></canvas>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
