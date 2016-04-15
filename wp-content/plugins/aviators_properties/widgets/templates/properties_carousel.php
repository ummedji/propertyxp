<div class="block-content clearfix <?php print $classes; ?>" <?php print $style; ?>>
    <?php if ($title): ?>
        <h2 class="<?php print $title_classes; ?>"><?php print $title; ?></h2>
    <?php endif; ?>

    <div class="block-content-inner row">
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