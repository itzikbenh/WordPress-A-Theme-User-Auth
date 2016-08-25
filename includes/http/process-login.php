<?php

function ath_login_user()
{
    //For redirect purposes
    $login_url = network_site_url( '/login' );
    $homepage  = network_site_url( '/' );

    $auth_nonce = $_POST['auth_nonce'];
    validate_nonce( $auth_nonce, $homepage );

    $username = sanitize_text_field( trim( $_POST['username'] ) );
    $password = trim( $_POST['password'] );
    $remember = isset( $_POST['remember'] ) ? 'true' : 'false';

    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    );

    //If wp_signon fails it will return an error.
    $user = wp_signon( $creds, false );

    if ( is_wp_error( $user ) )
    {
        $_SESSION["username"] = $username;
        $_SESSION["errors"]["login_error_url"] = "Invalid username and password combination";
        wp_redirect( $login_url );
        exit;
    }

    $_SESSION["home_success"] = "Welcome back $username!";
    wp_redirect( $homepage );
    exit;

}
