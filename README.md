# A-Theme-User-Auth
Plugin for allowing users to register into your WordPress site via front-end forms. Completely free of admin panel.

# NOTE:
This is not meant to be distributed since it only suits to specific use cases. It doesn't offer an options page to add or remove fields. This is geared toward developers who want to use it as a starting point and add their own code on top of it. Of course it's good enough out of the box as well. All depends on what you need.

In the functions.php file there is a function that redirects user to the login page after he logs out. This will apply for you as an admin to. Remove it if you wish.

This plugin assumes that your theme is using bootstrap and font-awesome. If not then style it however you wish.

# Features:
1. Registration form - accepts username, email, and password.
2. Login form - by username only for now, but I will change it to email soon, since it makes more sense.
3. Send Reset Link Form - accepts email and sends the user an email with a reset password link.
4. Password Reset Form - after reset link was verified the user will be able to reset his password.
5. Update Profile Form - allows the user to update his email and username. The username is something that WordPress doesn't allow to change technically.
6. Update Password Form - allows the user to update his password.
7. Email Verification - after user registers it sends him an email verification link to verify his email.
8. Success/Error messages - see session alerts below.

# SESSION Alerts
I handle all error/success messages via SESSIONS, however some of the messages need to appear at the home page after page redirect. If you want
everything to work as expected then please add this to the top of your home page.

```php
<?php if( isset( $_SESSION["home_error"] ) ): ?>
    <div class="alert alert-danger text-center home-alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $_SESSION["home_error"] ?>
    </div>
<?php endif; ?>

<?php if( isset( $_SESSION["home_success"] ) ): ?>
    <div class="alert alert-success text-center home-alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $_SESSION["home_success"] ?>
    </div>
<?php endif; ?>
```

# Helper Functions:
1. email_activated( $user ) - returns true if user verified his email. False if not. Use it to prohibit actions for users who didn't verify their email.

# Shortcodes:
1. [register_form]
2. [login_form]
3. [send_reset_link_form]
4. [password_reset_form] - Will redirect user to home page if he randomly accesses that page or if reset token is invalid.
5. [update_profile_form] - Will redirect user to home page if he's not logged in.
6. [update_password_form] - Will redirect user to home page if he's not logged in.
7. [email_verification_form] - This will only need to be used if something went wrong with the first email verification that is sent after user registers.

# Expected Permalinks And Related Forms:
1. '/register' -> [register_form]
2. '/login' -> [login_form]
3. '/request-password-reset-link' -> [send_reset_link_form]
4. '/reset-password' -> [password_reset_form]
5. '/update-profile' -> [update_profile_form]
6. '/update-password' -> [update_password_form]
7. '/email-verification' -> Only verifies the email. Nothing else.
8. '/request-email-verification-link' -> [email_verification_form]

If you have different permalinks then just go over the functions.php file and all the files in the http folder and modify redirect links.

# Expected Templates/Files:
1. __Template Name:__ "Auth Guest" __File:__ auth-guest.php - for registration and login forms.
2. __Template Name:__ "Auth User" __File:__ auth-user.php - for update profile/password, and email verification forms.
3. __Template Name:__ "Auth All" __File:__ auth-all.php - for reset password and send reset link forms.

I'm using these templates to check if a user is allowed to access that current page. For example, auth-guest.php is meant only for guests, so I will redirect logged in users that
try to access that page. If you modify it then you have to secure it by yourself.
I'm using templates which means that even if you change the URL it will still work.

#Security
If you use this plugin you use it at your own risk, however I tried to use the best practices and I relied on WordPress functions whenever I could. Codebase is very small so you can go over the includes/http folder and take a look how I process all requests. It's mostly form validation and the rest is WordPress helper functions. I don't deal with SQL queries directly so there shouldn't be any problems. If you do find one, please let me know so I can fix it.


