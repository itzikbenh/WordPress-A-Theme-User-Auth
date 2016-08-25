<?php
function ath_register_form()
{
    ?>

    <div id="register" class="ath-card-auth">

        <?php if( errors_has("register_error_url") ): ?>
            <div class="alert alert-danger text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_SESSION["errors"]["register_error_url"] ?>
            </div>
        <?php endif; ?>

        <div class="ath-card-content">

            <div class="ath-card-title">
                <h3 class="title">Welcome To Coverager</h3>
            </div>

            <form action="<?php echo get_admin_url() ?>admin-post.php" class="form-horizontal" method="post" enctype="multipart/form-data">

                <input type="hidden" name="auth_nonce" value="<?php echo wp_create_nonce( get_template_directory_uri( __FILE__ ) ) ?>" />
                <input type='hidden' name='action' value='submit_form_register' />

                <div class="<?php echo "form-group" . ( errors_has("username") ? " has-error" : "" );  ?>">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?php old("username") ?>">
                    <?php if( errors_has("username") ): ?>
                        <span class="help-block">
                            <strong><?php echo $_SESSION["errors"]["username"]; ?></strong>
                        </span>
                    <?php endif; ?>
                </div>

                <div class="<?php echo "form-group" . ( errors_has("email") ? " has-error" : "" );  ?>">
                     <input type="text" class="form-control" name="email" placeholder="Email" value="<?php old("email") ?>">
                     <?php if( errors_has("email") ): ?>
                         <span class="help-block">
                             <strong><?php echo $_SESSION["errors"]["email"]; ?></strong>
                         </span>
                     <?php endif; ?>
                </div>

                <div class="<?php echo "form-group" . ( errors_has("password") ? " has-error" : "" );  ?>">
                    <input type="password" class="form-control" id="password-register" name="password" placeholder="Password">
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
                    <button type="submit" class="btn btn-success btn-lg btn-block register">
                        <i class="fa fa-btn fa-user"></i> Register
                    </button>
                </div>

            </form>

        </div>

    </div>
    <?php
}
?>
