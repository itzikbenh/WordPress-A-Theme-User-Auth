<?php

function ath_update_password()
{
    $update_password_url = network_site_url( '/update-password' );
    $homepage            = network_site_url( '/' );

    $auth_nonce = $_POST['auth_nonce'];
    validate_nonce( $auth_nonce, $homepage );

    $user             = wp_get_current_user();
    $current_password = trim( $_POST['current_password'] );
    $new_password     = trim( $_POST['new_password'] );
    $password_confirm = trim( $_POST['password_confirm'] );

    $errors = [];

    //Return error if current don't match user's password
    if ( ! wp_check_password( $current_password, $user->user_pass, $user->ID ) )
    {
        $reset_link_url = network_site_url( '/request-password-reset-link' );
        $errors["current_password"] = "Invalid password. <a href='$reset_link_url'>Forgot password?</a>";
        $_SESSION["errors"] = $errors;
        wp_safe_redirect( $update_password_url );
        exit;
    }
    if( $new_password !== $password_confirm )
    {
        $errors["password_confirm"] = "Password confirmation don't match";
    }
    if( strlen( $new_password ) < 6 )
    {
        $errors["new_password"] = "Password must be at least 6 characters";
    }

    if( count( $errors ) > 0 )
    {
        $_SESSION["errors"] = $errors;
        wp_safe_redirect( $update_password_url );
        exit;
    }

    wp_set_password( $new_password, $user->ID );
    $_SESSION["success"] = "Password has been updated successfully. Please login again with your new password.";
    $login_url = network_site_url( '/login' );
    wp_safe_redirect( $login_url );
    exit;
}


?>
