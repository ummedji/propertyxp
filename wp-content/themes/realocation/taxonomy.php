<?php get_header(); ?>

    <div id="main-content" class="<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>col-sm-9<?php else : ?>col-sm-12<?php endif; ?>">
        <?php dynamic_sidebar( 'content-top' ); ?>

        <?php if ( have_posts() ) : ?>
            <?php $term = $wp_query->queried_object; ?>
            <h1><?php echo $term->name; ?></h1>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php aviators_get_template( 'content', null, 'row' ); ?>
            <?php endwhile; ?>

            <?php aviators_pagination(); ?>
        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>

        <?php dynamic_sidebar( 'content-bottom' ); ?>
    </div><!-- #main -->

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="sidebar col-sm-3">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div><!-- /#sidebar -->
<?php endif; ?>

<?php get_footer(); ?>