<td class="center">
    <?php print get_the_ID(); ?>
</td>

<td class="image-wrapper">
    <div class="image">
        <?php if (has_post_thumbnail(get_the_ID())): ?>
            <a href="<?php print get_permalink(); ?>">
                <img src="<?php print aviators_get_featured_image(get_the_ID(), 100, 100); ?>" alt="<?php the_title(); ?>">
            </a>
        <?php endif; ?>
    </div>
    <!-- /.image -->
</td><!-- /.item-image-wrapper -->

<td>
    <?php the_title(); ?>
</td>

<td>
    <?php print hydra_render_field(get_the_ID(), 'subtitle'); ?>
</td>

<td>
    <span class="label <?php echo get_post_status(get_the_ID()) == 'publish' ? 'label-success' : 'label-warning'; ?>">
        <?php print get_post_status(get_the_ID()); ?>
    </span>
</td>

<td>
    <?php $links = aviators_submission_actions('agent', get_the_ID()); ?>

    <?php foreach ($links as $link): ?>
        <a href="<?php echo $link['link']; ?>" class="<?php echo $link['btn_class']; ?>">
            <i class="<?php echo $link['icon_class']; ?>"></i>
            <?php echo $link['text']; ?>
        </a>
    <?php endforeach; ?>

    <?php if (!transactions_post_is_paid(get_the_ID()) && aviators_settings_get('transaction', 'submissions', 'submission_system') == 'paypal' && aviators_transaction_configuration_set()): ?>

        <a class="btn btn-primary" href="<?php echo aviators_transaction_paypal_button_link(get_the_ID()); ?>">
            <?php echo __('Buy now!', 'aviators'); ?>
        </a>
    <?php endif; ?>
</td><!-- /.col-md-4 -->