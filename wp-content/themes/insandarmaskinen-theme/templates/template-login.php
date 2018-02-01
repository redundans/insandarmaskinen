<?php
/**
 * Template Name: Logga in
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
			
			<div class="card" style="max-width: 20rem; transform: rotate(-1deg);">
				<div class="card-body">
					<p class="card-text text-center">
						<img class="medal mt-2 mb-2" style="max-width: 4rem;" src="<?php echo get_template_directory_uri(); ?>/dist/assets/images/support.svg">
					</p>
					<p class="card-text">Välkommen till <strong>Insändarmaskinen™</strong>. Logga in eller registrera dig för att komma åt plattformen.</p>
					<form name="login-form" id="sidebar-login-form" class="standard-form" action="<?php echo site_url( 'wp-login.php', 'login_post' ); ?>" method="post">
					<h2>Logga in</h2>
					<input type="text" name="log" id="sidebar-user-login" placeholder="<?php _e( 'Username', 'buddypress' ); ?>" class="input" value="<?php if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" />
					<input type="password" name="pwd" id="sidebar-user-pass" placeholder="<?php _e( 'Password', 'buddypress' ); ?>" class="input" value="" tabindex="98" />
					<label class="checkbox"><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> <?php _e( 'Remember Me', 'buddypress' ); ?></label>

					<?php do_action( 'bp_sidebar_login_form' ); ?>
					<input type="submit" class="btn" name="wp-submit" id="sidebar-wp-submit" value="<?php _e( 'Log In', 'buddypress' ); ?>" tabindex="100" />
					<input type="hidden" name="testcookie" value="1" />
				</form>
					<a href="/registrera" class="btn btn-block btn-link">Registrera dig</a>
				</div>
			</div>

		</div>
	</body>
</html>
