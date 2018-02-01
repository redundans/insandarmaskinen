<?php
/**
 * The template for displaying all single.
 */

get_header();

?>

<div class="wrapper" id="single-wrapper">

	<div id="content" class="container" tabindex="-1">

		<main class="site-main" id="main">

			<?php while ( have_posts() ) :
				the_post(); ?>

				<?php
					get_template_part( 'templates/content', 'single' );
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->


	</div>

</div><!-- Container end -->

<?php get_footer(); ?>
