<div class="property-item">
    <div class="property-box small">
        <div class="property-box-inner">
            <div class="property-box-header">
                <h3 class="property-box-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div class="property-box-subtitle"><?php print hydra_render_field(get_the_ID(), 'location', 'small'); ?></div>
            </div><!-- /.property-box-header -->

            <div class="property-box-picture">
                <div class="property-box-price"><?php echo hydra_render_field(get_the_ID(), 'price', 'grid'); ?></div><!-- /.property-box-price -->
                <div class="property-box-picture-inner">
                    <a href="<?php echo get_permalink(); ?>" class="property-box-picture-target">
                        <img src="<?php echo aviators_get_featured_image(get_the_ID(), 284, 284); ?>" alt="<?php the_title(); ?>">
                    </a><!-- /.property-box-picture-target -->
                </div><!-- /.property-picture-inner -->
            </div><!-- /.property-picture -->
        </div><!-- /.property-box-inner -->
    </div><!-- /.property-box -->
</div>

