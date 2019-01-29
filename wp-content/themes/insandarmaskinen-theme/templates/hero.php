<?php
/**
 * Hero setup.
 *
 * @package understrap
 */

?>
	<div class="wrapper" id="wrapper-hero">

		<div class="container">
			<div class="row justify-content-center">
		
				<div class="col-12 col-md-8">
<?php
	$headers = array(
		'Se hit!',
		'Så blir du bäst!',
		'Läs nedan!',
	);
	shuffle( $headers );
	?>

					<h1>👋 <?php echo esc_html( $headers[0] ); ?></h1>
					<div class="hero-content">
						<!--<p>Jag är <strike>upprörd</strike>, <strike>arg</strike>, <strike>glad</strike>, <strong>engagerad</strong> och tänker minsann skicka en <strong>insändare</strong> till varenda jädrans <strong>tidning</strong> i Sverige. Och jag tänker börja skriva den <strong>här och nu!</strong></p>-->
						<p><strong>Insändarmaskinen's</strong> egna mästarskribent <strong><a href="http://insandarmaskinen.test/medlemmar/christian/">christian</a></strong> har skrivit en utmärkt guide till hur du blir <strike>godkänd</strike>, <strike>rätt bra</strike>, <strong>bäst</strong> på att skriva insändare. Ladda ned, läs och kom gärna med egna tips på hur man blir en bättre insändarskribent.</p>
					</div>
					<a href="/skriv/" class="btn btn-outline-dark">Skriv insändare</a> <a href="http://insandarmaskinen.se/wp-content/uploads/2019/01/Guide-till-Insändarmaskinen.pdf" class="btn btn-link" download>Ladda ned guiden</a>
				</div>

			</div>

		</div>

	</div>

