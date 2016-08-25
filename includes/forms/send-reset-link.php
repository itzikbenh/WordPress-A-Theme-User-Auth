<?php

function ath_send_reset_link_form()
{
    ?>


     <div id="send-reset-link" class="ath-card-auth">

         <?php if( errors_has("reset_link_error_url") ): ?>
             <div class="alert alert-danger text-center">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                 <?php echo $_SESSION["errors"]["reset_link_error_url"] ?>
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
                 <h3 class="title">Reset Password Link</h3>
             </div>

             <form action="<?php echo get_admin_url() ?>admin-post.php" class="form-horizontal" method="post">

                 <input type="hidden" name="auth_nonce" value="<?php echo wp_create_nonce( get_template_directory_uri( __FILE__ ) ) ?>" />
                 <input type='hidden' name='action' value='submit_form_send_reset_link' />

                 <div class="form-group">
                     <input type="text" class="form-control" name="email" value="<?php old("email") ?>" placeholder="Email">
                 </div>

                 <div class="form-group">
                     <button type="submit" class="btn btn-success btn-lg btn-block send-reset-link">
                         <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                     </button>
                 </div>

             </form>

         </div>
     </div>

    <?php
}
?>
