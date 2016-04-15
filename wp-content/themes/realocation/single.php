<?php get_header(); ?>

<div id="main-content" class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
    <?php the_post(); ?>
    <?php aviators_get_content_template(get_post_type(), 'detail'); ?>
</div>

<?php if (is_active_sidebar('sidebar-1')) : ?>
    <div class="sidebar col-md-3 col-sm-3">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </div><!-- /#sidebar -->
<?php endif; ?>

<?php get_footer(); ?>
