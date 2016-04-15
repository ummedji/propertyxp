<div class="agent-row">
    <div class="row">
        <?php if(has_post_thumbnail(get_the_ID())): ?>
            <div class="agent-row-picture col-sm-5">
                <?php if($type = hydra_render_field(get_the_ID(), 'type', 'row')): ?>
                    <div class="agent-row-label agent-row-label-primary"><?php print $type; ?></div><!-- /.agent-row-picture-label -->
                <?php endif; ?>

                <div class="agent-row-picture-inner">
                    <a href="<?php the_permalink(); ?>" class="agent-row-picture-target">
                        <img src="<?php print aviators_get_featured_image(get_the_ID(), 230, 230); ?>" alt="<?php the_title(); ?>">
                    </a><!-- /.agent-row-picture-target -->
                </div><!-- /.agent-row-picture-inner -->
            </div><!-- /.agent-row-picture -->
        <?php endif; ?>

        <div class="agent-row-content col-sm-7">
            <h3 class="agent-row-title"><a href="<?php print get_permalink(); ?>"><?php the_title(); ?></a></h3><!-- /.agent-row-title -->
            <?php $subtitle = hydra_render_field(get_the_ID(), 'subtitle', 'row'); ?>
            <?php if (!empty($subtitle)): ?>
                <div class="agent-row-subtitle"><?php print hydra_render_field(get_the_ID(), 'subtitle', 'row'); ?></div><!-- /.agent-row-subtitle -->
            <?php endif; ?>

            <?php print hydra_render_group(get_the_ID(), 'contact_information', 'row'); ?>
            <?php print hydra_render_field(get_the_ID(), 'social', 'row'); ?>
        </div><!-- /.agent-row-content -->
    </div><!-- /.row -->
</div><!-- /.agent-row -->
