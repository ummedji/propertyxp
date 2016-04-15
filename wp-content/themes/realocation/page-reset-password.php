<?php
/**
 * Template Name: Reset Password
 */
?>

<?php get_header(); ?>

<div id="main-content">
    <?php if ( is_user_logged_in() ) : ?>
        <div class="col-md-12">
            <div class="alert alert-warning">
                <?php echo __(
                sprintf('You are already logged in. Please <a href="%s">logout</a> to reset your password.', site_url() . '/wp-login.php?action=logout'), 'aviators' ); ?>
            </div><!-- /.alert -->
        </div><!-- /.col-md-12 -->
    <?php else: ?>
        <div class="col-md-4 col-md-offset-4">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'content', 'simple' ); ?>
            <?php endwhile; ?>

            <form name="resetpassform" id="resetpassform" action="<?php echo esc_url( site_url( 'wp-login.php?action=resetpass&key=' . urlencode( $_GET['key'] ) . '&login=' . urlencode( $_GET['login'] ), 'login_post' ) ); ?>" method="post" autocomplete="off">

                <div class="form-group">
                    <label for="user_login"><?php echo __('Username or E-mail', 'aviators'); ?></label>
                    <input type="text" name="user_login" id="user_login" class="form-control" value="<?php echo esc_attr($user_login); ?>" size="20">
                </div><!-- /.form-group -->

                <p class="submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-block" value="<?php esc_attr_e('Reset Password'); ?>">
                </p>
            </form>
        </div><!-- /.col-md-4 -->
    <?php endif; ?>
</div>
<?php get_footer(); ?>