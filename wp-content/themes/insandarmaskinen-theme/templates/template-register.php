<?php
/**
 * Template Name: Registrering
 *
 * @package WordPress
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<title><?php wp_title('&raquo;','true','right'); ?><?php bloginfo('name'); ?></title>
	<?php wp_head(); ?>
</head>

	<body <?php body_class(); ?>>
		<div id="full-wrapper">
			
			<div class="card" style="max-width: 34rem;">
				<div class="card-body">

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'templates/content', 'page' ); ?>
					<?php endwhile; // end of the loop. ?>

				</div>
			</div>

		</div>
	</body>
	<?php wp_footer(); ?>
</html>
