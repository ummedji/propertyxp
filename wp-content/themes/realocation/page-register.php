<?php
/**
 * Template Name: Register
 */
?>

<?php get_header(); ?>
<?php aviators_profile_register_page(); ?>

    <div id="main-content">
        <?php dynamic_sidebar('content-top'); ?>

        <?php if (get_option('users_can_register') && !is_user_logged_in()) : ?>
            <div class="col-md-4 col-md-offset-4">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('content', 'simple'); ?>
                <?php endwhile; ?>



                <div class="box">
                    <?php $form = hydra_get_frontend_submission(NULL, 'profile'); ?>
                    <?php $renderer = new HydraAdvancedRender($form); ?>
                    <?php $renderer->renderStart(); ?>

                    <?php if (aviators_settings_get('profile', 'register', 'register')): ?>
                        <?php $renderer->renderField('name'); ?>
                        <?php $renderer->renderField('mail'); ?>

                        <?php if(aviators_settings_get('profile', 'register', 'password')): ?>
                            <?php $renderer->renderField('password'); ?>
                            <?php $renderer->renderField('password_check'); ?>

                            <div id="password-match">
                                <div class="match" style="display:none;">
                                    <strong><?php echo __('Password Match', 'aviators'); ?></strong>
                                </div>
                                <div class="mismatch" style="display:none;">
                                    <strong><?php echo __('Password Mismatch', 'aviators'); ?></strong>
                                </div>
                            </div>

                            <strong>
                                <?php echo __('Password Strength', 'aviators'); ?>
                            </strong>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                            </div>
                        <?php endif; ?>

                        <?php $disabled_fields = aviators_settings_get('profile', 'register', 'disabled_fields'); ?>
                        <?php $renderer->setRendered($disabled_fields); ?>
                        <?php $renderer->render(); ?>
                    <?php endif; ?>

                    <?php $renderer->renderClose(); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php dynamic_sidebar('content-bottom'); ?>
    </div><!-- /#main-content -->

    <?php if(aviators_settings_get('profile', 'register', 'password')): ?>
        <script>
            jQuery(function() {
                jQuery('input[type="password"]').first().passwordValidation({
                    mediumLabel: 'Medium',
                    strongLabel: 'Strong',
                    weakLabel: 'Weak'
                });
            });

            jQuery('#hydra-password-check, #hydra-password').keyup(function() {

                var pass = jQuery('#hydra-password').val();
                var passcheck = jQuery('#hydra-password-check').val();

                if(passcheck == pass) {
                    jQuery('#password-match .mismatch').hide();
                    jQuery('#password-match .match').show();
                } else {
                    jQuery('#password-match .mismatch').show();
                    jQuery('#password-match .match').hide();
                }
            })
        </script>
    <?php endif; ?>
<?php get_footer(); ?>