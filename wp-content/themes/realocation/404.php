<?php get_header(); ?>

<div id="main-content" class="col-md-12 col-sm-12">
    <?php dynamic_sidebar( 'content-top' ); ?>

    <div class="block-content block-content-small-padding">
        <div class="block-content-inner">
            <div class="hero">
                <strong>404</strong>
                <span><?php echo __('Page Not Found', 'aviators'); ?></span>
            </div><!-- /.hero -->
        </div><!-- /.block-content-inner -->
    </div><!-- /.block-content -->

    <?php dynamic_sidebar( 'content-bottom' ); ?>
</div><!-- /#main -->

<?php get_footer(); ?>