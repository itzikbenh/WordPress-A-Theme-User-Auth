<?php

function ath_email_verification_form()
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

     <div id="send-email-verification-link" class="ath-card-auth">

         <?php if( errors_has("email_verification_error_url") ): ?>
             <div class="alert alert-danger text-center">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                 <?php echo $_SESSION["errors"]["email_verification_error_url"] ?>
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
                 <h3 class="title">Email Verification Link</h3>
             </div>

             <form action="<?php echo get_admin_url() ?>admin-post.php" class="form-horizontal" method="post">

                 <input type="hidden" name="auth_nonce" value="<?php echo wp_create_nonce( get_template_directory_uri( __FILE__ ) ) ?>" />
                 <input type='hidden' name='action' value='submit_form_email_verification' />

                 <div class="form-group">
                     <input type="text" class="form-control" name="email" value="<?php echo $current_user->user_email ?>" placeholder="Email">
                 </div>

                 <div class="form-group">
                     <button type="submit" class="btn btn-success btn-lg btn-block send-email-verification-link">
                         <i class="fa fa-btn fa-envelope"></i> Send Email Verification Link
                     </button>
                 </div>

             </form>

         </div>
     </div>

    <?php
}