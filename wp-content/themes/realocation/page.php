<?php get_header(); ?>

<div id="main-content" class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
    <?php dynamic_sidebar( 'content-top' ); ?>

    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'content', get_post_format() ); ?>

        <?php /*if (comments_open( get_the_ID() ) ) : ?>
            <?php comments_template() ?>
        <?php endif;*/ ?>
    <?php endwhile; ?>

    <?php dynamic_sidebar( 'content-bottom' ); ?>
</div><!-- /#main -->

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="sidebar col-md-3 col-sm-3">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div><!-- /.sidebar -->
<?php endif; ?>

<?php get_footer(); ?>