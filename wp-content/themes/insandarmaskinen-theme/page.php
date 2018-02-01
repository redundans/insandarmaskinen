<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package understrap
 */

get_header();

?>

<div class="wrapper" id="page-wrapper">

	<div id="content" class="container" tabindex="-1">

		<main class="site-main" id="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php 
				if ( bp_is_directory() ) {
					get_template_part( 'templates/content', 'members' );
				} else if ( bp_is_user() ) {
					get_template_part( 'templates/content', 'profile' );
				} else {
					get_template_part( 'templates/content', 'page' );
				}
				?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->


	</div>

</div><!-- Container end -->

<?php get_footer(); ?>
