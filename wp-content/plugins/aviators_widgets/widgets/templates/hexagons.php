<div class="block-content clearfix <?php print $classes; ?>" <?php print $style; ?>>
    <?php if($title): ?>
        <h2 class="<?php print $title_classes; ?>"><?php print $title; ?></h2>
    <?php endif; ?>
    <div class="block-content-inner row">
        <?php for($i = 1; $i <= 3; $i++): ?>
            <?php $data = $instance[$i]; ?>
            <div class="col-sm-4">
                <div class="hex-wrapper center">
                    <div class="clearfix">
                        <?php if($data['icon']): ?>
                            <div class="hex col-xs-8 col-xs-offset-2 col-sm-8 col-sm-offset-2">
                                <div class="hex-inner">
                                    <img src="<?php print get_template_directory_uri(); ?>/assets/img/hex.png" alt="" class="hex-image">

                                    <div class="hex-content">
                                        <i class="<?php print $data['icon']; ?>"></i>
                                    </div><!-- /.hex-content -->
                                </div><!-- /.hex-inner -->
                            </div><!-- /.hex -->
                        <?php endif; ?>
                    </div><!-- /.clearfix -->

                    <h3><?php print $data['title']; ?></h3>

                    <?php if(isset($data['content'])): ?>
                        <p class="center">
                            <?php print do_shortcode($data['content']); ?>
                        </p>
                    <?php endif; ?>

                    <?php if(isset($data['link'])): ?>
                        <a href="<?php print $data['link'] ?>" class="<?php print $button_class; ?>"><?php print isset($data['button']) ? $data['button'] : __('Read More', 'aviators') ?></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endfor; ?>
    </div><!-- /.block-content-inner -->
</div>