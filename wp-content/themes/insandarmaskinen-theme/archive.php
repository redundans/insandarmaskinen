<?php
/**
 * The template for displaying all insandare.
 *
 * @package insandarmaskinen
 */

get_header();

?>

<div class="wrapper" id="page-wrapper">

	<div id="content" class="container" tabindex="-1">

		<main class="site-main" id="main">



			<header class="entry-header">
				<div class="row justify-content-center">
					<div class="col-md-8">
						<?php the_archive_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<div class="header-content">
							<p>Här hittar du alla insändare som vi skrivit under årens lopp.</p>
						</div>
					</div>
				</div>
			</header><!-- .entry-header -->

			<?php
				get_template_part( 'templates/loop', 'insandare' );
			?>

		</main><!-- #main -->


	</div>

</div><!-- Container end -->

<?php get_footer(); ?>
