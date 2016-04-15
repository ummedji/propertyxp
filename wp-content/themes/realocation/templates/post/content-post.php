<div <?php post_class() ?>>
    <div class="clearfix">
        <?php $thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ); ?>

        <div class="col-md-2">
            <div class="post-date">
                <span class="month"><?php echo get_the_date('M'); ?></span>
                <span class="day"><?php echo get_the_date('d'); ?></span>
            </div><!-- /.post-date -->
        </div>
        <?php if ( !empty( $thumbnail_url ) ) : ?>
            <div class="col-md-4">
                <div class="image-wrapper">
                    <div class="image">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    </div><!-- /.image -->

                    <?php aviators_edit_post_link(); ?>
                </div><!-- /.image-wrapper -->
            </div><!-- /.col-md-8 -->
        <?php endif; ?>

        <div class="col-md-<?php if ( !empty($thumbnail_url) ) : ?>6<?php else : ?>10<?php endif; ?>">


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
