<div class="agent-box">
    <div class="row">
        <?php if(has_post_thumbnail()): ?>
        <div class="agency-box-picture col-sm-12">
            <?php if($type = hydra_render_field(get_the_ID(), 'type', 'grid')): ?>
                <div class="agency-box-label agency-box-label-primary"><?php print $type; ?></div><!-- /.agent-row-picture-label -->
            <?php endif; ?>

            <div class="agency-box-picture-inner">
                <a href="<?php print get_permalink(); ?>" class="agent-box-picture-target">
                    <img src="<?php print aviators_get_featured_image(get_the_ID(), 260, 275) ?>" alt="<?php the_title(); ?>">
                </a><!-- /.agent-row-picture-target -->
            </div><!-- /.agent-row-picture-inner -->
        </div><!-- /.agent-row-picture -->
        <?php endif; ?>

        <div class="agency-box-content col-sm-12 center">
            <h3 class="agency-box-title"><a href="<?php print get_permalink(); ?>"><?php the_title(); ?></a></h3><!-- /.agent-row-title -->

            <?php print hydra_render_group(get_the_ID(), 'contact_information', 'row'); ?>
        </div><!-- /.agent-row-content -->
    </div><!-- /.row -->
</div><!-- /.agent-row -->
