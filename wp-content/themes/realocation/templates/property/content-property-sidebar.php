<div class="property-small clearfix">
    <?php if(has_post_thumbnail()): ?>
    <div class="property-small-picture col-sm-12 col-md-4">
        <div class="property-small-picture-inner">
            <a href="<?php echo get_permalink(); ?>" class="property-small-picture-target">
                <img src="<?php echo aviators_get_featured_image(get_the_ID(), 100, 100); ?>" alt="<?php the_title(); ?>">
            </a>
        </div><!-- /.property-small-picture -->
    </div><!-- /.property-small-picture -->
    <?php endif; ?>

    <div class="property-small-content col-sm-12 col-md-8">
        <h3 class="property-small-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3><!-- /.property-small-title -->
        <?php echo hydra_render_group(get_the_ID(), 'information', 'sidebar'); ?>
    </div><!-- /.property-small-content -->
</div>