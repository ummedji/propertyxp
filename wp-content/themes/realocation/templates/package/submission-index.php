<?php echo aviators_render_messages(); ?>

<?php if (is_user_logged_in()) : ?>
    <?php $current_user = wp_get_current_user(); ?>

    <?php aviators_submission_tabs(); ?>

    <?php query_posts(array(
        'post_type' => 'transactions',
        'status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'expired',
                'value' => false,
            ),
            array(
                'key' => 'paypal_user_id',
                'value' => $current_user->ID,
            ),
            array(
                'key' => 'payment_type',
                'value' => 'package',
            ),
        )
    )); ?>

    <?php if (have_posts()): ?>
        <?php aviators_get_template('content', $post_type, 'overview'); ?>
    <?php else: ?>
        <?php print __('You dont have any active package', 'aviators') ?>
    <?php endif; ?>

    <?php wp_reset_query(); ?>
<?php endif; ?>