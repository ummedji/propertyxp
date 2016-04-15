<div class="block-content clearfix <?php print $classes; ?>" <?php print $style; ?>>
    <?php if($title): ?>
        <h2 class="<?php print $title_classes; ?>"><?php print $title; ?></h2>
    <?php endif; ?>

    <?php if($text): ?>
        <div class="block-content-inner row">
            <?php print $text; ?>
        </div><!-- /.block-content-inner -->
    <?php endif; ?>
</div>