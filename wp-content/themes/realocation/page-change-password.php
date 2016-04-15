<?php
/**
 * Template Name: Change Password
 */
?>
<?php if ( ! is_user_logged_in() ) : ?>
  <?php aviators_add_message(__('You are not allowed to access this page as anonymous user. Please sign in before.', 'aviators'), 'danger'); ?>
  <?php wp_redirect( home_url() ); exit; ?>
<?php endif; ?>

<?php if ( !empty( $_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) : ?>
    <?php if ( $_POST['pass1'] == $_POST['pass2'] ) : ?>
        <?php wp_set_password( $_POST['pass1'], get_current_user_id() ); ?>
        <?php aviators_add_message(__('Password has been successfully changed. Now you are required to sign in.', 'aviators'), 'success'); ?>
        <?php wp_redirect( home_url() ); exit; ?>
    <?php else : ?>
        <?php aviators_add_message(__('Passwords are not same.', 'aviators'), 'danger'); ?>
    <?php endif; ?>
<?php endif; ?>

<?php get_header(); ?>

<?php if ( ! is_user_logged_in() ) : ?>
    <div class="col-md-12">
        <div class="alert alert-warning">
            <?php echo __(sprintf('Please sign in.', site_url() . '/wp-login.php?action=logout'), 'aviators' ); ?>
        </div><!-- /.alert -->
    </div><!-- /.col-md-12 -->
<?php else: ?>
    <div class="col-md-4 col-md-offset-4">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'content', 'simple' ); ?>
        <?php endwhile; ?>

        <form name="resetpassform" id="resetpassform" action="?" method="post" autocomplete="off">
            <div class="form-group">
                <label for="pass1"><?php echo __( 'New password', 'aviators' ); ?></label>
                <input type="password" name="pass1" id="pass1" class="form-control" size="20" value="" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="pass2"><?php echo __( 'Confirm new password', 'aviators' ); ?></label>
                <input type="password" name="pass2" id="pass2" class="form-control" size="20" value="" autocomplete="off">
            </div>

            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-block" value="<?php echo __('Set new password', 'aviators'); ?>">
        </form>
    </div><!-- /.col-md-4 -->
<?php endif; ?>

<?php get_footer(); ?>