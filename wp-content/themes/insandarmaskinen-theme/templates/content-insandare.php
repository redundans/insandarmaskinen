<?php
/**
 * Partial template for content in archive.php
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content row justify-content-center">
		<div class="col-md-10">

		<?php the_content(); ?>

		</div>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
