<?php
    $package = aviators_package_get_package_by_user(get_the_author_meta('id'));
?>

<div class="row">
    <div class="col-sm-4">
        <?php if(has_post_thumbnail(get_the_ID())): ?>
            <img src="<?php echo aviators_get_featured_image(get_the_ID());?>" class="img-responsive">
        <?php endif; ?>

        <?php if($package && aviators_profile_can_edit()): ?>

            <p>
                <?php echo __('You have active package:', 'aviators') . $package->post_title; ?>
            </p>

            <?php  $page = aviators_submission_get_submission_page('package', 'index'); ?>
            <a href="<?php print get_permalink($page); ?>" class="btn btn-primary btn-block"><?php echo __('View details', 'aviators'); ?></a>
        <?php endif; ?>

    </div>

    <div class="col-sm-8">
        <?php echo hydra_render_group(get_the_ID(), 'information'); ?>
    </div>
</div>
