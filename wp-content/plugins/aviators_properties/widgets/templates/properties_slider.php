<?php ?>
<div id="properties-slider" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach($slides as $index => $slide): ?>
            <li data-target="#properties-slider" data-slide-to="<?php echo $index; ?>" class="<?php if($index == 0 ) { echo "active"; } ?>"></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">

    <?php foreach($slides as $index => $slide): ?>

        <div class="item <?php if($index == 0) { print "active"; } ?>">
            <a href="<?php echo get_permalink($slide); ?>">
                <img src="<?php echo aviators_get_featured_image($slide->ID, 870, 420); ?> " alt="<?php echo $slide->post_title; ?>">
            </a>
            <div class="slider-info">
                <div class="price">
                    <?php echo hydra_render_field($slide->ID, 'price'); ?>
                </div>
                <!-- /.price-->

                <h2>
                    <a href="<?php echo get_permalink($slide); ?>"><?php echo $slide->post_title; ?></a>
                </h2>

                <?php echo hydra_render_group($slide->ID, 'meta'); ?>
            </div>
            <!-- /.slider - info-->
        </div><!-- /.slide-->
    <?php endforeach; ?>
    </div>

    <a class="left carousel-control" href="#properties-slider" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>

    <a class="right carousel-control" href="#properties-slider" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>