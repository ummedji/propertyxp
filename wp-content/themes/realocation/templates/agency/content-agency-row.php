<div class="agency-row clearfix">

    <?php if(has_post_thumbnail()): ?>
        <div class="agency-row-picture col-sm-6 col-md-5 col-lg-4">
            <div class="agency-row-picture-inner">                
                <a href="<?php print get_permalink(get_the_ID()); ?>" class="agency-row-picture-target">
                    <img src="<?php echo aviators_get_featured_image(get_the_ID(), 284, 284); ?>" alt="<?php the_title(); ?>">
                </a><!-- /.agency-row-picture-target -->
            </div><!-- /.agency-row-picture-inner -->
        </div><!-- /.agency-row-picture  -->
    <?php endif; ?>

    <div class="agency-row-content col-sm-6 col-md-7 col-lg-8">
        <h3 class="agency-row-title"><a href="<?php print get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h3>

        <?php print hydra_render_group(get_the_ID(), 'contact_information', 'row'); ?>
        <?php print hydra_render_field(get_the_ID(), 'social', 'row'); ?>
    </div><!-- /.agency-row-content -->
</div>