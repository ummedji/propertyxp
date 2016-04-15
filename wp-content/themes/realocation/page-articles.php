<?php
/**
 * Template Name: Articles
 */
?>
<?php get_header(); ?>

<div class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
    <?php if (dynamic_sidebar('content-top')) : ?><?php endif; ?>

    <div class="posts">
    <?php 
    $args = array('post_type'=>'article_type', 'post_status'=>'publish', 'posts_per_page'=> -1);	
    $loop = new WP_Query($args);?>
        <?php while ($loop->have_posts()) : $loop->the_post(); ?>
            <?php aviators_get_template(); ?>

        <?php endwhile; ?>
    </div><!-- /.posts -->

    <?php aviators_pagination(); ?>
    <?php if (dynamic_sidebar('content-bottom')) : ?><?php endif; ?>
</div><!-- /#main -->

<?php if (is_active_sidebar('sidebar-1')) : ?>
    <div class="sidebar col-md-3 col-sm-3">
        <?php get_sidebar('sidebar-1'); ?>
    </div><!-- /#sidebar -->
<?php endif; ?>

<?php get_footer(); ?>