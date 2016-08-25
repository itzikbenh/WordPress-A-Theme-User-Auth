<?php
//Will redirect user to '/login' page after he logs out.
function redirect_to_login()
{
    $login_url = network_site_url( '/login' );
    wp_safe_redirect( $login_url );
    exit;
}
add_action('wp_logout', 'redirect_to_login' );

//Starts the session on init.
function ath_start_session()
{
    if( !session_id() )
    {
        session_start();
    }
}
add_action('init', 'ath_start_session');

//Shows old input incase of form failed to submit
function old($field)
{
    if( isset( $_SESSION[$field] ) )
    {
        echo $_SESSION[$field];
    }
}

//Shows old input in update forms incase there is no new one
function old_or_new($field, $user)
{
    if( isset( $_SESSION[$field] ) )
    {
        return $_SESSION[$field];
    }
    return $user->$field;
}
//Returns true is there is an error for the passed field.
function errors_has($key)
{
    if( isset( $_SESSION['errors'] ) && array_key_exists( $key, $_SESSION['errors'] ) )
    {
        return true;
    }
}
//Returns true is there is a success message for the passed field.
function success_has( $key )
{
    if( isset( $_SESSION[$key] ) )
    {
        return true;
    }
}

//Makes sure only users with verified reset-link can fill the form. Very important that this would be called before headers are sent.
function check_reset_link()
{
    if ( is_page( 'reset-password' ) )
    {
        if( isset( $_REQUEST['key'] ) && isset( $_REQUEST['login'] ) )
        {
            $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
            if( is_wp_error ($user ) )
            {
                $lost_password_url = network_site_url( '/request-password-reset-link' );
                $_SESSION["errors"]["reset_link_error_url"] = "Reset link is invalid, you may request another one here.";
                wp_safe_redirect( $lost_password_url );
                exit;
            }
        }
        else
        {
            wp_safe_redirect( network_site_url( '/' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'check_reset_link' );

//Makes sure only logged in users can access these pages. Very important that this would be called before headers are sent.
//In reality I will probably create a specific template that is protected and only run this function there, without having to rely on the url.
function redirect_if_not_logged_in()
{
    if ( is_page_template( 'auth-user.php' ) )
    {
        if( !is_user_logged_in() )
        {
            wp_safe_redirect( network_site_url( '/login' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'redirect_if_not_logged_in' );

function redirect_if_logged_in()
{
    if ( is_page_template( 'auth-guest.php' ) )
    {
        if( is_user_logged_in() )
        {
            wp_safe_redirect( network_site_url( '/' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'redirect_if_logged_in' );

//Reset all sessions
function reset_sessions()
{
    unset($_SESSION['errors']);
    unset($_SESSION['success']);
    unset($_SESSION['username']);
    unset($_SESSION['user_login']);
    unset($_SESSION['user_email']);
    unset($_SESSION['email']);
    unset($_SESSION['nonce_url']);
    unset($_SESSION['home_success']);
    unset($_SESSION['home_error']);
    unset($_SESSION['email_verification_error_url']);
}
add_action( 'wp_footer', 'reset_sessions' );

function validate_nonce( $auth_nonce, $homepage )
{
    $nonce = isset( $auth_nonce ) ? $auth_nonce : 'random string';

    if ( !wp_verify_nonce( $nonce, get_template_directory_uri( __FILE__ ) ) ) {
        $_SESSION["home_error"] = "Something went wrong";
        wp_redirect( $homepage );
        exit;
    }
}

function validate_registration( $username, $email, $password, $password_confirm )
{
    if( username_exists( $username ) )
    {
        $errors["username"] = "Username exists already";
    }
    if( strlen( $username ) < 3 )
    {
        $errors["username"] = "Username must be at least 3 characters";
    }
    if( email_exists( $email ) )
    {
        $errors["email"] = "Email exists already";
    }
    if ( empty( $email ) || ! is_email( $email ) )
    {
        $errors["email"] = "Valid Email is required";
    }
    if( $password !== $password_confirm )
    {
        $errors["password_confirm"] = "Password confirmation don't match";
    }
    if( strlen( $password ) < 6 )
    {
        $errors["password"] = "Password must be at least 6 characters";
    }

    return $errors;
}

function send_email_verification_link( $user )
{
    $user_login = $user->user_login;
    $user_email = $user->user_email;
    $key = get_password_reset_key( $user );

    if ( is_wp_error( $key ) ) {
        $_SESSION["errors"]["reset_link_error_url"] = "Something went wrong, please try again or contact support.";
        wp_safe_redirect( $lost_password_url );
        exit;
    }

    $message = __('This is an email verification for the following account:') . "\r\n\r\n";
    $message .= network_home_url( '/' ) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= __('If email was verified already, just ignore this email and nothing will happen.') . "\r\n\r\n";
    $message .= __('To verify your email, visit the following address:') . "\r\n\r\n";
    $message .= '<' . network_site_url("email-verification?action=ve&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $title = sprintf( __('[%s] Email Verification'), $blogname );
    //Filter the subject of the password reset email.
    $title = apply_filters( 'retrieve_password_title', $title, $user_login, $user );
    //Filter the message body of the password reset mail.
    $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user );

    if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
    {
        $_SESSION["email_verification_error_url"] = "Sorry, verification email could not be sent. You may request another one here.";
        wp_safe_redirect( '/request-email-verification-link' );
    }
}

function verify_email()
{
    if ( is_page_template( 'email-verification.php' ) )
    {
        if( isset( $_REQUEST['key'] ) && isset( $_REQUEST['login'] ) )
        {
            $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
            if( is_wp_error ($user ) )
            {
                $lost_password_url = network_site_url( '/request-password-reset-link' );
                $_SESSION["home_error"] = "Email verification link is no longer valid. You may request another one here.";
                wp_safe_redirect( network_site_url( '/request-email-verification-link' ) );
                exit;
            }
            $user_id = $user->ID;
            update_user_meta( $user_id, "email_activated", "1" );
            $_SESSION["home_success"] = "Email has been verified successfully. Thank you!";
            wp_safe_redirect( network_site_url( '/' ) );
            exit;
        }
        else
        {
            wp_safe_redirect( network_site_url( '/' ) );
            exit;
        }
    }
}
add_action( 'template_redirect', 'verify_email' );

//For reset password link
function send_reset_link_email( $user )
{
    // Redefining user_login ensures we return the right case in the email.
    $user_login = $user->user_login;
    $user_email = $user->user_email;
    $key = get_password_reset_key( $user );

    if ( is_wp_error( $key ) ) {
        $_SESSION["errors"]["reset_link_error_url"] = "Something went wrong, please try again or contact support.";
        wp_safe_redirect( $lost_password_url );
        exit;
    }

    $message = __('Someone has requested a password reset for the following account:') . "\r\n\r\n";
    $message .= network_home_url( '/' ) . "\r\n\r\n";
    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
    $message .= '<' . network_site_url("reset-password?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

    $title = sprintf( __('[%s] Password Reset'), $blogname );

    //Filter the subject of the password reset email.
    $title = apply_filters( 'retrieve_password_title', $title, $user_login, $user );

    // Filter the message body of the password reset mail.
    $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user );

    if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
    {
        $_SESSION["errors"]["reset_link_error_url"] = "The email could not be sent, please try again or contact support.";
        wp_safe_redirect( $lost_password_url );
        exit;
    }
}


//Checks if user activated his email
function email_activated( $user )
{
    $email_activated = get_user_meta( $user->ID, "email_activated", true );
    if( is_user_logged_in() && $email_activated )
    {
        return true;
    }
    else
    {
        return false;
    }
}









