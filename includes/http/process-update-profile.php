<?php

function ath_update_profile()
{
    global $wpdb;

    $update_user_url = network_site_url( '/update-profile' );
    $homepage        = network_site_url( '/' );

    $auth_nonce = $_POST['auth_nonce'];
    validate_nonce( $auth_nonce, $homepage );

    $user     = wp_get_current_user();
    $username = sanitize_user( trim( $_POST['username'] ), true );
    $email    = sanitize_text_field( trim( $_POST['email'] ) );

    $errors = [];

    //Makes sure username would be unique, but won't cause an error incase he didn't change his current username
    if( username_exists( $username ) && $username !== $user->user_login )
    {
        $errors["username"] = "Username exists already";
    }
    if( strlen( $username ) < 3 )
    {
        $errors["username"] = "Username must be at least 3 characters";
    }
    //Makes sure email would be unique, but won't cause an error incase he didn't change his current email
    if( email_exists( $email ) && $email !== $user->user_email )
    {
        $errors["email"] = "Email exists already";
    }
    if( empty( $email ) || ! is_email( $email ) )
    {
        $errors["email"] = "Valid Email is required";
    }


    if( count( $errors ) > 0 )
    {
        $_SESSION["errors"] = $errors;
        $_SESSION["user_email"] = $email;
        $_SESSION["user_login"] = $username;
        wp_safe_redirect( $update_user_url );
        exit;
    }

    //We want to keep the user_nicename format as WordPress does.
    $user_nicename = mb_substr( $username, 0, 50 );
    $user_nicename = sanitize_title( $user_nicename );

    $user_data = array(
        'user_login' =>  $username,
        'user_email' =>  $email,
        'user_nicename' => $user_nicename
    );

    //IF we get an error here that means we have a problem in our app.
    if( false === $wpdb->update( $wpdb->users, $user_data, array( 'ID' => $user->ID ) ) )
    {
        $_SESSION["errors"]["update_profile_url"] = "Sorry, update failed due to an unxpected error. Please contact support if it continues";
        wp_safe_redirect( $update_user_url );
        exit;
    }

    //If username has changed then WordPress would logout the user so in that case we will redirect him to login pages
    $_SESSION["success"] = "Profile has been updated successfully. Please login again.";
    $login_url = network_site_url( '/login' );
    wp_logout();
    wp_safe_redirect( $login_url );
    exit;
}


?>
