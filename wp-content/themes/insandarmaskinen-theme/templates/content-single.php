<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header mb-4">
		<div class="row justify-content-center">
			<div class="col-md-8 mt-4">
				<?php the_title( '<h1 class="entry-title pb-2">', '</h1>' ); ?>
				<div class="header-content pt-4 text-md-center">
					<span class="text-secondary"><?php the_date(); ?> av <a href="<?php echo bp_core_get_user_domain( get_the_author_id() ) ?>"><?php the_author(); ?></a></span>
				</div>
			</div>
		</div>
	</header><!-- .entry-header -->


	<div class="entry-content row justify-content-center">
		<div class="col-md-8 insandare-content">

		<?php the_content(); ?>

		<div class="tags-content">
			<h2><?php the_publications_count(); ?> publiceringar</h2>
			<div id="tags" data-post="<?php echo esc_html( get_the_id() ); ?>" data-publications='<?php the_publications(); ?>'></div>
		</div>

		</div>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
