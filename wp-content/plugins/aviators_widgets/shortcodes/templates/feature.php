<div class="feature">
<?php if($icon): ?>
    <div class="feature-icon col-xs-2 col-sm-2">
        <div class="feature-icon-inner">
            <i class="fa <?php print $icon; ?>"></i>
        </div><!-- /.feature-icon-inner -->
    </div><!-- /.feature-icon -->
<?php endif; ?>

    <div class="feature-content <?php if($icon) { echo "col-xs-10 col-sm-10"; } else { echo "col-xs-12 col-sm-12"; } ?>">
        <?php if($title): ?>
            <h3 class="feature-title"> <?php print $title; ?></h3>
        <?php endif; ?>
        <?php if($content): ?>
            <p class="feature-body">
                <?php print $content; ?>
            </p>
        <?php endif; ?>
    </div><!-- /.feature-content -->
</div><!-- /.feature -->
