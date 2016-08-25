<?php
function ath_login_form()
{
    ?>

    <div id="login" class="ath-card-auth">

        <?php if( errors_has("login_error_url") ): ?>
            <div class="alert alert-danger text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_SESSION["errors"]["login_error_url"] ?>
            </div>
        <?php endif; ?>

        <?php if( success_has("success") ): ?>
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_SESSION["success"] ?>
            </div>
        <?php endif; ?>

        <div class="ath-card-content">

            <div class="ath-card-title">
                <h3 class="title">Welcome Back!</h3>
            </div>

            <form action="<?php echo get_admin_url() ?>admin-post.php" class="form-horizontal" method="post">

                <input type="hidden" name="auth_nonce" value="<?php echo wp_create_nonce( get_template_directory_uri( __FILE__ ) ) ?>" />
                <input type='hidden' name='action' value='submit_form_login' />

                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php old("username") ?>">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" id="password-login" name="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" value="true"> Remember Me
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block login">
                        <i class="fa fa-btn fa-sign-in"></i> Login
                    </button>
                </div>
                <a class="btn btn-link forgot-password" href="<?php echo network_site_url( '/request-password-reset-link' ) ?>">Forgot Your Password?</a>

            </form>

        </div>

    </div>
    <?php
}
?>