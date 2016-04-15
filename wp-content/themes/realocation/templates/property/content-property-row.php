<div class="property-row">
    <div class="row">
        <div class="property-row-picture col-sm-6 col-md-6 col-lg-4">

            <div class="property-row-picture-inner">
                <a href="<?php echo get_permalink(); ?>" class="property-row-picture-target">
                    <img src="<?php echo aviators_get_featured_image(get_the_ID(), 284, 284); ?>" alt="<?php the_title(); ?>">
                </a>

                <div class="property-row-meta">
                    <?php echo hydra_render_group(get_the_ID(), 'meta', 'row'); ?>
                </div>
                <!-- /.property-row-meta -->
            </div>
            <!-- /.property-row-picture -->
        </div>
        <!-- /.property-row-picture -->

        <div class="property-row-content col-sm-6 col-md-6 col-lg-8 col-md-6 col-lg-8">
            <h3 class="property-row-title">
                <a href="<?php echo get_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h3><!-- /.property-row-title -->

            <div class="property-row-subtitle">
                <?php echo hydra_render_field(get_the_ID(), 'location', 'row'); ?>
            </div><!-- /.property-row-subtitle -->

            <div class="property-row-price"><?php echo hydra_render_field(get_the_ID(), 'price', 'row'); ?></div>
            <!-- /.property-row-price -->

            <?php the_excerpt(); ?>
        </div>
        <!-- /.property-row-content -->
    </div>
    <!-- /.row -->
</div>

