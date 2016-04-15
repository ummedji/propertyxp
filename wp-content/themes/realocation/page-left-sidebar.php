<?php
/**
 * Template Name: Left Sidebar
 */
?>
<?php get_header(); ?>


<?php if (is_active_sidebar('top')) : ?>
    <?php if (dynamic_sidebar('top')) : ?><?php endif; ?>
<?php endif ?>

    <div class="container">
        <div class="row">
            <?php if (is_active_sidebar('sidebar-1')) : ?>
                <div class="sidebar col-md-3 col-sm-3">
                    <?php dynamic_sidebar('sidebar-1'); ?>
                </div><!-- /#sidebar -->
            <?php endif; ?>

            <div id="main-content"
                 class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
                <?php echo aviators_render_messages(); ?>
                <?php if (dynamic_sidebar('content-top')) : ?><?php endif; ?>

                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('content', get_post_format()); ?>

                    <?php if (comments_open(get_the_ID())) : ?>
                        <?php comments_template() ?>
                    <?php endif; ?>
                <?php endwhile; ?>

                <?php if (dynamic_sidebar('content-bottom')) : ?><?php endif; ?>
            </div>
            <!-- /#main-content -->
        </div>
        <!-- /.row -->
    </div><!-- /.container -->

<?php if (get_sidebar('bottom')) : ?><?php endif ?>


<?php get_footer(); ?>