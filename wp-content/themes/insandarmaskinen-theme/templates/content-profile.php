<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<h1 class="entry-title"><?php the_title(); ?>
				<?php the_medals( bp_displayed_user_id() ); ?></h1>
				<div class="header-content">
					<?php if ( '' !== get_the_author_meta( 'user_description', bp_displayed_user_id() ) ) { ?>
						<p><?php echo esc_html( get_the_author_meta( 'user_description', bp_displayed_user_id() ) ); ?></p>
					<?php } ?>
					<?php if( '' === xprofile_get_field_data( 3, bp_displayed_user_id() ) && bp_displayed_user_id() === get_current_user_id() ) { ?>
						<p><a href="<?php echo bp_core_get_user_domain( bp_displayed_user_id() ) . '/profile/edit/group/1/'; ?>" class="btn btn-outline-dark btn-lg">Skriv en presentation</a></p>
					<?php } else { ?>
						<p><?php echo xprofile_get_field_data( 3, bp_displayed_user_id() ); ?></p>
					<?php } ?>
				</div>
			</div>
		</div>
	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
