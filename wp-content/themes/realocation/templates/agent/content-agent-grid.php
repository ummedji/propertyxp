<div class="agent-box">
    <div class="row">
        <?php if(has_post_thumbnail()): ?>
        <div class="agent-box-picture col-sm-12">
            <?php if($type = hydra_render_field(get_the_ID(), 'type', 'grid')): ?>
                <div class="agent-box-label agent-box-label-primary"><?php print $type; ?></div><!-- /.agent-row-picture-label -->
            <?php endif; ?>

            <div class="agent-box-picture-inner">
                <a href="<?php print get_permalink(); ?>" class="agent-box-picture-target">
                    <img src="<?php print aviators_get_featured_image(get_the_ID(), 260, 275) ?>" alt="<?php the_title(); ?>">
                </a><!-- /.agent-row-picture-target -->
            </div><!-- /.agent-row-picture-inner -->
        </div><!-- /.agent-row-picture -->
        <?php endif; ?>

        <div class="agent-box-content col-sm-12">
            <h3 class="agent-box-title"><a href="<?php print get_permalink(); ?>"><?php the_title(); ?></a></h3><!-- /.agent-row-title -->

            <?php if($subtitle = hydra_render_field(get_the_ID(), 'subtitle', 'grid')): ?>
                <div class="agent-box-subtitle"><?php print $subtitle ?></div><!-- /.agent-row-subtitle -->
            <?php endif; ?>
            <?php print hydra_render_field(get_the_ID(), 'social', 'grid'); ?>
        </div><!-- /.agent-row-content -->
    </div><!-- /.row -->
</div><!-- /.agent-row -->
