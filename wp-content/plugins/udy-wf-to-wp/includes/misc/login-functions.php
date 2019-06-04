<?php
function udesly_get_reset_password_error() {
	$errors = new WP_Error();
	if ( ! isset( $_GET['key'], $_GET['login'] ) ) {
		$errors->add('notVisible', __( 'Sorry, this form should not be visible' ) );
	} else {
		$user = check_password_reset_key( $_GET['key'], $_GET['login'] );

		if ( is_wp_error( $user ) ) {
			if ( $user->get_error_code() === 'expired_key' ) {
				$errors->add( 'expiredkey', __( 'Sorry, that key has expired. Please try again.' ) );
			} else {
				$errors->add( 'invalidkey', __( 'Sorry, that key does not appear to be valid.' ) );
			}
		}
	}
	return $errors;
}