<?php

function ath_update_profile_form()
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

    <div id="update-profile" class="ath-card-auth">

        <?php if( errors_has("update_profile_url") ): ?>
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_SESSION["errors"]["update_profile_url"] ?>
            </div>
        <?php endif; ?>

        <div class="ath-card-content">

            <div class="ath-card-title">
                <h3 class="title">Update Profile</h3>
            </div>

            <form action="<?php echo get_admin_url() ?>admin-post.php" class="form-horizontal" method="post">

                <input type="hidden" name="auth_nonce" value="<?php echo wp_create_nonce( get_template_directory_uri( __FILE__ ) ) ?>" />
                <input type='hidden' name='action' value='submit_form_update_profile' />

                <div class="<?php echo "form-group" . ( errors_has("username") ? " has-error" : "" );  ?>">
                    <input type="text" class="form-control" name="username" value="<?php echo old_or_new("user_login", $current_user) ?>" placeholder="Username">
                    <?php if( errors_has("username") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["username"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="<?php echo "form-group" . ( errors_has("email") ? " has-error" : "" );  ?>">
                    <input type="text" class="form-control" name="email" value="<?php echo old_or_new("user_email", $current_user) ?>" placeholder="Password">
                    <?php if( errors_has("email") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["email"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block update-profile">
                        <i class="fa fa-btn fa-user"></i> Update
                    </button>
                </div>

            </form>

        </div>
    </div>


    <?php

}

?>
