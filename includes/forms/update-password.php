<?php

function ath_update_password_form()
{
    ?>

    <?php
        //We have a function that checks it for us already, but just incase we will check again.
        if( !is_user_logged_in() )
        {
            exit;
        }

        $current_user = wp_get_current_user();
    ?>

    <div id="update-password" class="ath-card-auth">

        <?php if( errors_has("update_password_url") ): ?>
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_SESSION["errors"]["update_password_url"] ?>
            </div>
        <?php endif; ?>

        <div class="ath-card-content">

            <div class="ath-card-title">
                <h3 class="title">Update Password</h3>
            </div>

            <form action="<?php echo get_admin_url() ?>admin-post.php" class="form-horizontal" method="post">

                <input type="hidden" name="auth_nonce" value="<?php echo wp_create_nonce( get_template_directory_uri( __FILE__ ) ) ?>" />
                <input type='hidden' name='action' value='submit_form_update_password' />

                <div class="<?php echo "form-group" . ( errors_has("current_password") ? " has-error" : "" );  ?>">
                    <input type="password" class="form-control" name="current_password" placeholder="Current Password">
                    <?php if( errors_has("current_password") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["current_password"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="<?php echo "form-group" . ( errors_has("new_password") ? " has-error" : "" );  ?>">
                    <input type="password" class="form-control" name="new_password" placeholder="New Password">
                    <?php if( errors_has("new_password") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["new_password"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="<?php echo "form-group" . ( errors_has("password_confirm") ? " has-error" : "" );  ?>">
                    <input type="password" class="form-control" name="password_confirm"  placeholder="Confirm New Password">
                    <?php if( errors_has("password_confirm") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["password_confirm"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block update-password">
                        <i class="fa fa-btn fa-shield"></i> Update
                    </button>
                </div>

            </form>

        </div>
    </div>

    <?php

}


?>
