<?php
/**
 * Template Name: Empty Content
 */
?>

<?php get_header(); ?>


    <div class="alert-no-margin">
        <?php echo aviators_render_messages(); ?>
    </div><!-- /.aler-no-margin -->

    <?php if (is_active_sidebar('top')) : ?>
        <?php if (dynamic_sidebar('top')) : ?><?php endif; ?>
    <?php endif ?>

    <div class="container">
        <div class="row">
            <div id="main-content" class="empty col-md-12 col-sm-12">
                <?php echo aviators_render_messages(); ?>
                <?php if (dynamic_sidebar('content-top')) : ?><?php endif; ?>

                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('content', get_post_format()); ?>
                <?php endwhile; ?>
                <?php if (dynamic_sidebar('content-bottom')) : ?><?php endif; ?>
            </div>
            <!-- /#main-content -->
        </div>
        <!-- /.row -->
    </div><!-- /.container -->


<?php get_footer(); ?>