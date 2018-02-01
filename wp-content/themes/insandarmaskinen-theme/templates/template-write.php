<?php
/**
 * Template Name: Skriv insändare
 *
 * @package WordPress
 */

get_header();

?>

<div class="wrapper" id="page-wrapper">

	<div id="content" class="container" tabindex="-1">

		<main class="site-main" id="main">

			<?php while ( have_posts() ) :
				the_post(); ?>

				<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

					<header class="entry-header mb-4 pb-4">
						<div class="row justify-content-center">
							<div class="col-md-8">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
								<div class="header-content">
									<p><?php the_content(); ?></p>
								</div>
							</div>
						</div>
					</header><!-- .entry-header -->

					<div class="entry-content row justify-content-center mt-4 pt-4">
						<div class="col-md-10">

							<form id="insandare-form">
							<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-interval="false">
								<div class="carousel-inner">
									<div class="carousel-item active">
										<div class="form-group">
											<input type="text" id="insandare-subject" name="subject" placeholder="Ämnesrad" class="form-control mb-0" />
										</div>
										<div class="form-group">
											<textarea name="content" id="insandare-content" class="form-control" placeholder="Författa din insändare här..." rows="10"></textarea>
										</div>		
									</div>
									<div class="carousel-item">
										<div class="form-group">
											<label for="insandare-from">Välj avsändare</label>
											<textarea name="from" id="insandare-from" class="form-control" placeholder="T.ex. vän av ordning" rows="1"></textarea>
										</div>
										<div class="form-group">
											<textarea name="from" id="insandare-contact" class="form-control" placeholder="" rows="5" disabled><?php echo esc_html( xprofile_get_field_data( 2, get_current_user_id() ) ); ?></textarea>
											<span class="form-text text-muted mt-4 mb-4"><span class="oi oi-warning"></span> Dina kontaktuppgifter ändrar du under dina sidor.</span>
										</div>
									</div>
									<div class="carousel-item">
										<label for="exampleInputEmail1">Välj mottagare</label>
										
										<?php
												$paper_categories = get_terms( 'tidningar', array(
													'hide_empty' => false,
													'parent' => 0,
												) );
												foreach ($paper_categories as $paper_category) {
													?>
										<div id="accordion<?php echo esc_html( $paper_category->slug ); ?>" class="accordion mb-4">
											<div class="accordion-head d-flex justify-content-between">
												<div class="custom-control custom-checkbox">
													<input type="checkbox" name="paper_parents[]" value="<?php echo esc_html( $paper_category->slug ); ?>" class="custom-control-input" id="check-<?php echo esc_html( $paper_category->slug ); ?>">
													<label class="custom-control-label" for="check-<?php echo esc_html( $paper_category->slug ); ?>"><?php echo esc_html( $paper_category->name ); ?></label>
												</div>
												<a data-toggle="collapse" href="#<?php echo esc_html( $paper_category->slug ); ?>" role="button" aria-expanded="true" aria-controls="<?php echo esc_html( $paper_category->slug ); ?>">
													<span class="oi oi-chevron-bottom"></span>
													<span class="oi oi-chevron-top"></span>
												</a>
											</div>
											<div id="<?php echo esc_html( $paper_category->slug ); ?>" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion<?php echo esc_html( $paper_category->slug ); ?>">
												<div class="row">
													<?php
													$papers = get_terms( 'tidningar', array(
														'hide_empty' => false,
														'parent' => $paper_category->term_id,
													) );

													foreach ($papers as $paper) {
													?>
													<div class="col-md-4 col-sm-5">
														<div class="custom-control custom-checkbox">
															<input name="papers[]" type="checkbox" value="<?php echo esc_html( $paper->slug ); ?>" class="custom-control-input" id="<?php echo esc_html( $paper->slug ); ?>">
															<label class="custom-control-label" for="<?php echo esc_html( $paper->slug ); ?>"><?php echo esc_html( $paper->name ); ?></label>
														</div>
													</div>
													<?php
													}
													?>
												</div>
											</div>
										</div>
											<?php
												}
											?>

									</div>
									<div class="carousel-item">
										<div class="carousel-end">
										<img class="waiting-list" src="<?php echo get_template_directory_uri(); ?>/dist/assets/images/waiting-list.svg" />
										<p>Din insändare är nu schemalagd för att skickas.</p>
									</div>
									</div>
								</div>
								<div id="carousel-footer" class="d-flex d-flex justify-content-between align-items-center">
									<ol class="carousel-indicators">
										<li data-target="#carouselExampleIndicators" class="active">1</li>
										<li data-target="#carouselExampleIndicators">2</li>
										<li data-target="#carouselExampleIndicators">3</li>
									</ol>
									<a id="carouselExampleIndicatorsButton" class="btn btn-primary btn-lg" href="#carouselExampleIndicators" data-slide="next">Välj avsändare</a>
								</div>
							</div>
							</form>

						</div>

					</div><!-- .entry-content -->

				</article><!-- #post-## -->

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->


	</div>

</div><!-- Container end -->

<?php get_footer(); ?>
