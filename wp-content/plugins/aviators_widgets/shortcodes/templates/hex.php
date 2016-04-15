<div class="hex-wrapper center">
    <div class="clearfix">
        <?php if($icon): ?>
            <div class="hex col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2">
                <div class="hex-inner">
                    <img src="<?php print get_template_directory_uri(); ?>/assets/img/hex.png" alt="" class="hex-image">

                    <div class="hex-content">
                        <i class="<?php print $icon; ?>"></i>
                    </div><!-- /.hex-content -->
                </div><!-- /.hex-inner -->
            </div><!-- /.hex -->
        <?php endif; ?>
    </div><!-- /.clearfix -->

    <h3><?php print $title; ?></h3>
    <?php print do_shortcode($content); ?>
</div>