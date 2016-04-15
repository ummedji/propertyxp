<div class="block-content clearfix background-transparent">
    <?php if($title): ?>
        <h2 class="transparent"><?php print $title; ?></h2>
    <?php endif; ?>

    <div class="panel-group" id="<?php print $accordion_id; ?>">
        <?php for($index = 1; $index <= $count; $index++): ?>
            <?php $data = $instance[$index]; ?>

            <?php if(isset($data['title']) && isset($data['content']) && $data['title'] && $data['content']): ?>
                <div class="panel panel-default">
                    <div class="panel-heading <?php if ( $index == 1 ) : ?><?php echo 'active'; ?><?php endif; ?>">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#<?php print $accordion_id; ?>" href="#collapse<?php echo $accordion_id . '-' . $index; ?>">
                                <?php echo $data['title']; ?>
                            </a>
                        </h4>
                    </div><!-- /.panel-heading -->

                    <div id="collapse<?php echo $accordion_id . '-' . $index; ?>" class="panel-collapse collapse <?php if ( $index == 1 ): ?><?php echo 'in'; ?><?php endif; ?>">
                        <div class="panel-body">
                            <?php echo do_shortcode( $data['content'] ); ?>
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel-heading -->
                </div><!-- /.panel -->
            <?php endif; ?>
        <?php endfor; ?>
    </div>
</div>