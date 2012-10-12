<?php
/*
Template Name: Skriv insändare
*/
?>
<?php get_header(); ?>

	<div class="span12" role="main">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div class="page-header">
				  <h1> Här är maskinen <small>Bli en gubbe på 10 min</small></h1>
				</div>
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry">

						<?php the_content( ); ?>

						<p><br/>
							<a href="#" class="btn btn-success">Skriv insändare nu!</a>
						</p>
					</div>

				</div>

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ); ?>

	</div><!-- .padder -->

<?php get_footer(); ?>
