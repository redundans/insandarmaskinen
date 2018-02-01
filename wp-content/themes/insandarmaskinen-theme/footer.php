<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

?>

<div class="wrapper" id="wrapper-footer">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info text-md-center">

						<p>
							<strong>Insändarmaskinen™</strong> är byggd med hjälp av <a href="<?php echo esc_url( __( 'https://wordpress.org/','insandarmaskinen' ) ); ?>" target="_blank">WordPress</a> och <a href="<?php echo esc_url( __( 'https://buddypress.org/','insandarmaskinen' ) ); ?>" target="_blank">BuddyPress</a>. <br/> Vill du hjälpa till med att utveckla maskinen så hittar du projektet på <a href="<?php echo esc_url( __( 'https://github.com/redundans/insandarmaskinen','insandarmaskinen' ) ); ?>" target="_blank">Github</a>.
						</p>

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

