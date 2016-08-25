<?php
/*
Plugin Name: A-Theme User Auth
Description: Plugin for allowing users to register into your WordPress site via front-end forms. Completely free of admin panel.
Version: 1.0
Author: Isaac Ben Hutta
License: GPLv2
*/
/* Copyright 2016 Isaac Ben Hutta
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License */

function ath_styles()
{
    wp_enqueue_style( 'plugin_css', plugin_dir_url( __FILE__ ) . 'style.css' );
}
add_action( 'wp_enqueue_scripts', 'ath_styles' );

include(plugin_dir_path( __FILE__ ) . '/includes/functions.php');

include(plugin_dir_path( __FILE__ ) . '/includes/forms/register.php');
include(plugin_dir_path( __FILE__ ) . '/includes/forms/login.php');
include(plugin_dir_path( __FILE__ ) . '/includes/forms/send-reset-link.php');
include(plugin_dir_path( __FILE__ ) . '/includes/forms/reset-password.php');
include(plugin_dir_path( __FILE__ ) . '/includes/forms/update-profile.php');
include(plugin_dir_path( __FILE__ ) . '/includes/forms/update-password.php');
include(plugin_dir_path( __FILE__ ) . '/includes/forms/email-verification.php');

include(plugin_dir_path( __FILE__ ) . '/includes/http/process-register.php');
include(plugin_dir_path( __FILE__ ) . '/includes/http/process-login.php');
include(plugin_dir_path( __FILE__ ) . '/includes/http/process-send-reset-link.php');
include(plugin_dir_path( __FILE__ ) . '/includes/http/process-reset-password.php');
include(plugin_dir_path( __FILE__ ) . '/includes/http/process-update-profile.php');
include(plugin_dir_path( __FILE__ ) . '/includes/http/process-update-password.php');
include(plugin_dir_path( __FILE__ ) . '/includes/http/process-email-verification.php');

add_shortcode('register_form', 'ath_register_form');
add_shortcode('login_form', 'ath_login_form');
add_shortcode('send_reset_link_form', 'ath_send_reset_link_form');
add_shortcode('password_reset_form', 'ath_password_reset_form');
add_shortcode('update_profile_form', 'ath_update_profile_form');
add_shortcode('update_password_form', 'ath_update_password_form');
add_shortcode('email_verification_form', 'ath_email_verification_form');


//Not private submissions - only for users that are not logged in
add_action('admin_post_nopriv_submit_form_register', 'ath_register_user');
add_action('admin_post_nopriv_submit_form_login', 'ath_login_user');
add_action('admin_post_nopriv_submit_form_send_reset_link', 'ath_send_reset_link');
add_action('admin_post_nopriv_submit_form_reset_password', 'ath_reset_password');

//Only for logged in users
add_action('admin_post_submit_form_update_profile', 'ath_update_profile');
add_action('admin_post_submit_form_update_password', 'ath_update_password');
add_action('admin_post_submit_form_send_reset_link', 'ath_send_reset_link');
add_action('admin_post_submit_form_reset_password', 'ath_reset_password');
add_action('admin_post_submit_form_email_verification', 'ath_email_verification');




