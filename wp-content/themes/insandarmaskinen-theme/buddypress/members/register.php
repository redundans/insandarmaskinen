<?php
/**
 * BuddyPress - Members Register
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div id="none-buddypress">

	<?php

	/**
	 * Fires at the top of the BuddyPress member registration page template.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_register_page' ); ?>

	<div class="page" id="register-page">

		<form action="" name="signup_form" id="signup_form" class="" method="post" enctype="multipart/form-data">

		<?php if ( 'registration-disabled' == bp_get_current_signup_step() ) : ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php

				/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
				do_action( 'template_notices' ); ?>

			</div>

			<?php

			/**
			 * Fires before the display of the registration disabled message.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_before_registration_disabled' ); ?>

				<p><?php _e( 'User registration is currently not allowed.', 'buddypress' ); ?></p>

			<?php

			/**
			 * Fires after the display of the registration disabled message.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_after_registration_disabled' ); ?>
		<?php endif; // registration-disabled signup step ?>

		<?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php

				/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
				do_action( 'template_notices' ); ?>

			</div>

			<p><?php _e( 'Registering for this site is easy. Just fill in the fields below, and we\'ll get a new account set up for you in no time.', 'buddypress' ); ?></p>

			<?php

			/**
			 * Fires before the display of member registration account details fields.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_account_details_fields' ); ?>

			<div class="row justify-content-center">

				<div class="register-section col-12" id="basic-details-section">

					<?php /***** Basic Account Details ******/ ?>

					<h5><?php _e( 'Account Details', 'buddypress' ); ?></h5>

					<div class="form-group">
						<label for="signup_username" class="sr-only"><?php _e( 'Username', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
						<?php

						/**
						 * Fires and displays any member registration username errors.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_signup_username_errors' ); ?>
						<input type="hidden" name="signup_username" id="signup_username" class="form-control" value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes( 'username' ); ?> placeholder="<?php _e( 'Username', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?>" />
					</div>

					<div class="form-group">
						<label for="signup_email" class="sr-only"><?php _e( 'Email Address', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
						<?php

						/**
						 * Fires and displays any member registration email errors.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_signup_email_errors' ); ?>
						<input type="email" name="signup_email" id="signup_email" value="<?php bp_signup_email_value(); ?>" class="form-control" <?php bp_form_field_attributes( 'email' ); ?> placeholder="<?php _e( 'Email Address', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?>" />
					</div>

					<div class="form-group">
						<label for="signup_password" class="sr-only"><?php _e( 'Choose a Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
						<?php

						/**
						 * Fires and displays any member registration password errors.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_signup_password_errors' ); ?>
						<input type="password" name="signup_password" id="signup_password" value="" class="password-entry form-control" <?php bp_form_field_attributes( 'password' ); ?> placeholder="<?php _e( 'Choose a Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?>" />
						<span id="pass-strength-result"></span>
					</div>

					<div class="form-group">
						<label for="signup_password_confirm" class="sr-only"><?php _e( 'Confirm Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
						<?php

						/**
						 * Fires and displays any member registration password confirmation errors.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_signup_password_confirm_errors' ); ?>
						<input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" class="password-entry-confirm form-control" <?php bp_form_field_attributes( 'password' ); ?> placeholder="<?php _e( 'Confirm Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?>" />
					</div>

					<?php

					/**
					 * Fires and displays any extra member registration details fields.
					 *
					 * @since 1.9.0
					 */
					do_action( 'bp_account_details_fields' ); ?>

				</div><!-- #basic-details-section -->

			<?php

			/**
			 * Fires after the display of member registration account details fields.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_after_account_details_fields' ); ?>

			<?php /***** Extra Profile Details ******/ ?>

			<?php if ( bp_is_active( 'xprofile' ) ) : ?>

				<?php

				/**
				 * Fires before the display of member registration xprofile fields.
				 *
				 * @since 1.2.4
				 */
				do_action( 'bp_before_signup_profile_fields' ); ?>

				<div class="register-section col-12" id="profile-details-section">

					<h5 class="mt-2 sr-only"><?php _e( 'Profile Details', 'buddypress' ); ?></h5>

					<?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
					<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<div<?php bp_field_css_class( 'editfield' ); ?>>

							<?php
							$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
							$field_type->edit_field_html();

							/**
							 * Fires after the display of the visibility options for xprofile fields.
							 *
							 * @since 1.1.0
							 */
							do_action( 'bp_custom_profile_edit_fields' ); ?>

						</div>

					<?php endwhile; ?>

					<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

					<?php endwhile; endif; endif; ?>

					<?php

					/**
					 * Fires and displays any extra member registration xprofile fields.
					 *
					 * @since 1.9.0
					 */
					do_action( 'bp_signup_profile_fields' ); ?>

				</div><!-- #profile-details-section -->

				<?php

				/**
				 * Fires after the display of member registration xprofile fields.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_after_signup_profile_fields' ); ?>

			<?php endif; ?>

			<?php

			/**
			 * Fires before the display of the registration submit buttons.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_before_registration_submit_buttons' ); ?>

			<div class="submit col col-md-8 text-center mt-4">
				<input type="submit" name="signup_submit" id="signup_submit" class="btn btn-primary btn-lg" value="<?php esc_attr_e( 'Complete Sign Up', 'buddypress' ); ?>" />
			</div>

			</div>

			<?php

			/**
			 * Fires after the display of the registration submit buttons.
			 *
			 * @since 1.1.0
			 */
			do_action( 'bp_after_registration_submit_buttons' ); ?>

			<?php wp_nonce_field( 'bp_new_signup' ); ?>

		<?php endif; // request-details signup step ?>

		<?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php

				/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
				do_action( 'template_notices' ); ?>

			</div>

			<?php

			/**
			 * Fires before the display of the registration confirmed messages.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_before_registration_confirmed' ); ?>

			<div id="template-notices" role="alert" aria-atomic="true">
				<?php if ( bp_registration_needs_activation() ) : ?>
					<p><?php _e( 'You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'buddypress' ); ?></p>
				<?php else : ?>
					<p><?php _e( 'You have successfully created your account! Please log in using the username and password you have just created.', 'buddypress' ); ?></p>
				<?php endif; ?>
			</div>

			<?php

			/**
			 * Fires after the display of the registration confirmed messages.
			 *
			 * @since 1.5.0
			 */
			do_action( 'bp_after_registration_confirmed' ); ?>

		<?php endif; // completed-confirmation signup step ?>

		<?php

		/**
		 * Fires and displays any custom signup steps.
		 *
		 * @since 1.1.0
		 */
		do_action( 'bp_custom_signup_steps' ); ?>

		</form>

	</div>

	<?php

	/**
	 * Fires at the bottom of the BuddyPress member registration page template.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_register_page' ); ?>

</div><!-- #buddypress -->
