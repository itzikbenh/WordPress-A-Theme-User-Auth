<?php
function ath_password_reset_form()
{
    ?>

    <div id="reset-password" class="ath-card-auth">

        <div class="ath-card-content">

            <div class="ath-card-title">
                <h3 class="title">Reset Password</h3>
            </div>

            <form action="<?php echo get_admin_url() ?>admin-post.php" class="form-horizontal" method="post">

                <input type="hidden" name="auth_nonce" value="<?php echo wp_create_nonce( get_template_directory_uri( __FILE__ ) ) ?>" />
                <input type='hidden' name='action' value='submit_form_reset_password' />

                <input type="hidden" name="key" value="<?php echo $_REQUEST['key'] ?>">
                <input type="hidden" name="login" value="<?php echo $_REQUEST['login'] ?>">

                <div class="<?php echo "form-group" . ( errors_has("email") ? " has-error" : "" );  ?>">
                    <input type="text" class="form-control" name="email" placeholder="email">
                    <?php if( errors_has("email") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["email"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="<?php echo "form-group" . ( errors_has("password") ? " has-error" : "" );  ?>">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <?php if( errors_has("password") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["password"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="<?php echo "form-group" . ( errors_has("password_confirm") ? " has-error" : "" );  ?>">
                    <input type="password" class="form-control" name="password_confirm" placeholder="Confirm Password">
                    <?php if( errors_has("password_confirm") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["password_confirm"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block">
                        <i class="fa fa-btn fa-refresh"></i> Reset Password
                    </button>
                </div>

            </form>

        </div>
    </div>

    <?php

}

?>
