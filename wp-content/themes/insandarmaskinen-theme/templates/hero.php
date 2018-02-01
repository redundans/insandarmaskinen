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
		'Meh, hallå!',
		'Vad i h*lvete!',
		'Nä nu...',
		'Ärade medborgare!',
	);
	shuffle($headers);
?>

					<h1><?php echo $headers[0]; ?></h1>
					<div class="hero-content">
						<p>Jag är <strike>upprörd</strike>, <strike>arg</strike>, <strike>glad</strike>, <strong>engagerad</strong> och tänker minsann skicka en <strong>insändare</strong> till varenda jädrans <strong>tidning</strong> i Sverige. Och jag tänker börja skriva den <strong>här och nu!</strong></p>
					</div>
					<a href="/skriv/" class="btn btn-outline-dark">Börja skriva nu</a>
				</div>

			</div>

		</div>

	</div>

