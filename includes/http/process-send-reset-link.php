<?php
//Takes care of sending the reset password link to the user's email
function ath_send_reset_link()
{
    //For redirect purposes
    $lost_password_url = network_site_url( '/request-password-reset-link' );
    $homepage          = network_site_url( '/' );

    $auth_nonce = $_POST['auth_nonce'];
    validate_nonce( $auth_nonce, $homepage );

    $email = sanitize_text_field( trim( $_POST['email'] ) );

    //Incase there is an error we want keep the email field filled
    $_SESSION['email'] = $email;

    if ( empty( $email ) || ! is_email( $email ) )
    {
        $_SESSION["errors"]["reset_link_error_url"] = "Valid Email is required.";
        wp_safe_redirect( $lost_password_url );
        exit;
    }

    $user = get_user_by( 'email', $email );
    if( empty( $user ) )
    {
        $_SESSION["errors"]["reset_link_error_url"] = "There is no user registered with that email address.";
        wp_safe_redirect( $lost_password_url );
        exit;
    }

    send_reset_link_email( $user );

    $_SESSION["success"] = "Reset link has been sent to your email";
    wp_safe_redirect( $lost_password_url );
    exit;
}




?>
