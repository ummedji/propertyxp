<?php get_header(); ?>

<div class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
    <?php /*if (dynamic_sidebar('content-top')) : ?><?php endif; ?>

    <div class="posts">
        <?php while (have_posts()) : the_post(); ?>
            <?php aviators_get_template(); ?>

            <?php if (comments_open(get_the_ID())) : ?>
                <?php comments_template() ?>
            <?php endif; ?>
        <?php endwhile; ?>
    </div><!-- /.posts -->

    <?php aviators_pagination(); ?>
    <?php if (dynamic_sidebar('content-bottom')) : ?><?php endif; */ ?>
   <div  class="clo-md-12 center blog-links">
       <a href="#" data-filter="*"><span>All</span></a>
       <a href="<?php bloginfo('url'); ?>/blog/" ><span>Blog</span></a>
       <a href="<?php bloginfo('url'); ?>/news/"><span>News</span></a>
     </div>
    <?php echo do_shortcode('[wmls name="Masonry Blog Posts" id="1"]'); ?>
</div><!-- /#main -->

<?php if (is_active_sidebar('sidebar-1')) : ?>
    <div class="sidebar col-md-3 col-sm-3">
        <?php get_sidebar('sidebar-1'); ?>
    </div><!-- /#sidebar -->
<?php endif; ?>

<?php get_footer(); ?>