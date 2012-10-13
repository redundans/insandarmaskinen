<?php if ( !is_user_logged_in() && !is_page('registrera') ) { header( 'Location: /registrera' ); }  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
		<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<?php do_action( 'bp_head' ); ?>
		<?php wp_head(); ?>
    	<link href="<?php echo get_bloginfo('stylesheet_directory'); ?>/css/bootstrap.css" rel="stylesheet">
	</head>

	<body <?php body_class(); ?> id="insandarmaskinen">
		<div class="navbar navbar-static-top">
	      <div class="navbar-inner">
	        <div class="container">
	          <button type="button" class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="brand" href="<?php echo get_bloginfo('home'); ?>"><img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/img/logo_small.png"></a>
	          <div class="nav-collapse collapse">
            		<?php if ( bp_loggedin_user_id() ) : $current_user = wp_get_current_user(); ?>
						<ul class="nav pull-right">
						  <li class="dropdown">
						    <a class="dropdown-toggle avatar" data-toggle="dropdown" href="#">
						        <?php echo get_avatar( bp_loggedin_user_id(), 35 ); ?>
						    </a>
						    <ul id="nav" class="dropdown-menu">
						    	<li class="menu-item menu-item-type-custom"><a href="/medlemmar/<?php echo $current_user->user_login; ?>/profile/">Användarprofil</a></li>
								<li class="menu-item menu-item-type-custom"><a href="/medlemmar/<?php echo $current_user->user_login; ?>/messages/">Meddelanden</a></li>
								<li class="menu-item menu-item-type-custom"><a href="/medlemmar/<?php echo $current_user->user_login; ?>/settings/">Inställningar</a></li>
								<li class="menu-item menu-item-type-custom"><a href="<?php echo wp_logout_url( '/' ); ?>">Logga ut</a></li>
							</ul>
						  </li>
						</ul>
					<?php endif; ?> 
	        <!--    <?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'menu_class' => 'nav', 'theme_location' => 'primary', 'fallback_cb' => 'bp_dtheme_main_nav' ) ); ?> -->
	          </div><!--/.nav-collapse -->
	        </div>
	      </div>
	    </div>

		<?php do_action( 'bp_before_header' ); ?>
		<?php do_action( 'bp_after_header' ); ?>
		<?php do_action( 'bp_before_container' ); ?>

		<div class="container">
			<div class="row">