<div class="block-content clearfix front_crausol_slider as_fec_property <?php print $classes; ?>" <?php print $style; ?>>
    <?php if ($title): ?>
        <div class="col-md-12 text-center">
           <h2 class="<?php print $title_classes; ?>"><?php print $title; ?></h2>
        </div>
    <?php endif; ?>

    <div class="block-content-inner row fec_property">
        <ul class="bxslider clearfix">
            <?php while (have_posts()) : the_post(); ?>
                <li>
                    <?php aviators_get_content_template('property', 'small'); ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <!-- /.block-content-inner -->
</div>