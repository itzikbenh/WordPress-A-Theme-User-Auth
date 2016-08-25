<?php
//resets user's password on success
function ath_reset_password()
{
    $homepage = network_site_url( '/' );

    $auth_nonce = $_POST['auth_nonce'];
    validate_nonce( $auth_nonce, $homepage );

    $key              = $_POST['key'];
    $login            = $_POST['login'];
    $email            = sanitize_text_field( trim( $_POST['email'] ) );
    $password         = trim( $_POST['password'] );
    $password_confirm = trim( $_POST['password_confirm'] );

    //Just to make sure we check again if the reset-link is valid.
    //Returns the user or an error.
    $user = check_password_reset_key($key, $login);
    //Incase user needs to request another reset-link
    $reset_link_url = network_site_url( '/request-password-reset-link' );
    if( is_wp_error( $user ) )
    {
        $_SESSION['errors']['reset-link-error'] = "Invalid reset link, you may request another one <a href='$reset_link_url'>here</a>";
        wp_safe_redirect( $reset_link_url );
        exit;
    }

    $user_email = $user->user_email;

    $errors = [];
    //order matters here. If email is empty or not valid in terms of syntax then it will show the proper error for that instead.
    if( $email !== $user->user_email )
    {
        $errors['email'] = "Entered email don't match to the reset link credentials, you may request another one <a href='$reset_link_url'>here</a>.";
    }
    if ( empty( $email ) || ! is_email( $email ) )
    {
        $errors['email'] = "Valid Email is required";
    }
    if( $password !== $password_confirm )
    {
        $errors["password_confirm"] = "Password confirmation don't match";
    }
    if( strlen( $password ) < 6 )
    {
        $errors["password"] = "Password must be at least 6 characters";
    }

    if( count( $errors ) > 0 )
    {
        $_SESSION['errors'] = $errors;
        $_SESSION["email"] = $email;
        wp_safe_redirect( wp_get_referer() );
        exit;
    }

    wp_set_password( $password, $user->ID );

    $login_url = network_site_url( '/login' );
    $_SESSION['success'] = "Password changed successfully. Login here.";
    wp_safe_redirect( $login_url );
    exit;

}


?>
