<?php

function ath_email_verification()
{
    //For redirect purposes
    $email_verification_url = network_site_url( '/request-email-verification-link' );
    $homepage               = network_site_url( '/' );

    $auth_nonce = $_POST['auth_nonce'];
    validate_nonce( $auth_nonce, $homepage );

    $email = sanitize_text_field( trim( $_POST['email'] ) );

    if ( empty( $email ) || ! is_email( $email ) )
    {
        $_SESSION["errors"]["email_verification_error_url"] = "Valid Email is required.";
        wp_safe_redirect( $email_verification_url );
        exit;
    }

    $user = get_user_by( 'email', $email );
    if( empty( $user ) )
    {
        $_SESSION["errors"]["email_verification_error_url"] = "There is no user registered with that email address.";
        wp_safe_redirect( $email_verification_url );
        exit;
    }

    if( email_activated( $user ) )
    {
        $_SESSION["success"] = "Your email has been verified already.";
        wp_safe_redirect( $email_verification_url );
        exit;
    }

    send_email_verification_link( $user );

    $_SESSION["success"] = "Email verification link has been sent to your email";
    wp_safe_redirect( $email_verification_url );
    exit;
}

?>