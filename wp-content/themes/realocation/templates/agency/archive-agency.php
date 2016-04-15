<?php
    // there is only row display
    $display = "row";
?>

<div class="items-list row">
    <?php while ( have_posts() ) : the_post(); ?>
        <?php aviators_get_content_template('agency', $display); ?>
    <?php endwhile; ?>
</div><!-- /.items-list -->