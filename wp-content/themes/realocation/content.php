<div <?php post_class() ?>>
    <div class="clearfix">
        <div class="col-md-12">
            <h2>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <?php echo aviators_edit_post_link(); ?>
            </h2>

            <div class="content-wrapper">
                <div class="content">
                    <?php if ( is_single() || is_page()) : ?>
                        <?php the_content(); ?>

                    <?php else: ?>
                        <?php the_excerpt(); ?>
                    <?php endif; ?>
                </div><!-- /.content -->
            </div><!-- /.content-wrapper -->
        </div><!-- /.col-md-8 -->
    </div>
</div>
