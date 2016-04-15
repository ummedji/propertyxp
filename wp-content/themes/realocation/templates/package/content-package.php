<div class="pricing-col <?php if(aviators_package_is_featured()): ?> featured<?php endif;?>">
    <div class="pricing-header">
        <h3 class="pricing-title"><?php the_title(); ?></h3>
        <?php print hydra_render_group(get_the_ID(), 'header'); ?>
    </div><!-- /.pricing-header -->

    <div class="pricing-content">
        <?php the_content(); ?>
    </div><!-- /.pricing-content -->

    <?php if(aviators_settings_get('transaction', 'submissions', 'submission_system') == 'package'): ?>
    <div class="pricing-action center">
        <?php $link = aviators_transaction_paypal_button_link(get_the_ID()); ?>

        <?php if($link): ?>
        <a class="btn btn-primary" href="<?php print $link ?>">
            <?php echo aviators_transaction_paypal_button_text(get_the_ID()); ?>
        </a>
        <?php else: ?>
            <?php echo aviators_transaction_paypal_button_text(get_the_ID()); ?>
        <?php endif; ?>
    </div><!-- /.pricing-action -->
    <?php endif; ?>
</div><!-- /.pricing-col -->