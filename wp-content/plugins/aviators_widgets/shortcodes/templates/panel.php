<div class="panel panel-default">
    <div class="panel-heading <?php if ( $open ) : ?><?php echo 'active'; ?><?php endif; ?>">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $panel_index; ?>">
                <?php echo $title; ?>
            </a>
        </h4>
    </div><!-- /.panel-heading -->

    <div id="collapse<?php echo $panel_index; ?>" class="panel-collapse collapse <?php if ( $open ): ?><?php echo 'in'; ?><?php endif; ?>">
        <div class="panel-body">
            <?php echo $content; ?>
        </div><!-- /.panel-body -->
    </div><!-- /.panel-heading -->
</div><!-- /.panel -->

