<?php
/**
 * Template Name: Login
 */
?>

<?php get_header(); ?>

<?php if ( is_user_logged_in() ) : ?>
    <div class="col-md-12">
        <div class="alert alert-warning">
            <?php echo __('You are already logged in.', 'aviators'); ?>
        </div><!-- /.alert -->
    </div><!-- /.col-md-12 -->
<?php else: ?>
    <div class="col-md-4 col-md-offset-4">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'content', 'simple' ); ?>
        <?php endwhile; ?>

        <form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
            <div class="form-group">
                <label for="user_login"><?php echo __( 'Username', 'aviators' ) ?></label>
                <input type="text" name="log" id="user_login" class="form-control" value="<?php echo esc_attr($user_login); ?>" size="20">
            </div><!-- /.form-group -->

            <div class="form-group">
                <label for="user_pass"><?php echo __( 'Password', 'aviators' ) ?></label>
                <input type="password" name="pwd" id="user_pass" class="form-control" value="" size="20">
            </div><!-- /.form-group -->

            <p class="submit">
                <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary btn-block" value="<?php echo __('Log In', 'aviators'); ?>">
                <input type="hidden" name="redirect_to" value="<?php echo site_url(); ?>">
            </p>
        </form>
    </div><!-- /.col-md-4 -->
<?php endif; ?>

<?php get_footer(); ?>