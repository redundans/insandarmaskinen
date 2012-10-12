<?php get_header(); ?>

	<div class="span8" role="main">

		<?php do_action( 'bp_before_blog_page' ); ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div class="page-header">
					<h1><?php the_title(); ?></h1>
				</div>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry">

						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>
						<?php $papers = wp_get_post_terms( get_the_ID(), 'paper' ); ?>
						
						<div class="btn-group">
						  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						    Rapportera publicering
						    <span class="caret"></span>
						  </a>
						  <ul class="dropdown-menu">
						  	<?php foreach ($papers as $paper) { ?>
						    	<li><a href="#"><i class="<?php $published = get_post_meta( get_the_ID(), $paper->slug, TRUE); if( !empty( $published  ) ) echo 'icon-ok'; ?>"></i> <?php echo $paper->name; ?></a></li>
						  	<?php } ?>
						  </ul>
						</div>
						<script>
							$(document).ready(function() {
								$('.dropdown-menu a').click( function(e){
									var icon = $(this).find('i');
									if( $(icon).hasClass('icon-ok') ){
										$(this).find('i').removeClass('icon-ok');
									} else {
										$(this).find('i').addClass('icon-ok');
									}
								});
							});
						</script>

					</div>

				</div>

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ); ?>

	</div><!-- .padder -->

<?php get_footer(); ?>
