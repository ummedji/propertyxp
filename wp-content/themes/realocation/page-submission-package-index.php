<?php
/**
 * Template Name: Package Submission Index
 */
?>

<?php aviators_submission_permission_check(); ?>
<?php aviators_transaction_configuration_set(); ?>

<?php get_header(); ?>
<?php aviators_submission_process_actions(); ?>

<div id="main-content" class="col-md-12">
    <?php dynamic_sidebar('content-top'); ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'content', 'simple' ); ?>
    <?php endwhile; ?>

    <?php $post_type = "package"; ?>
    <?php aviators_get_template('submission', 'package', 'index'); ?>
    <?php dynamic_sidebar('content-bottom'); ?>
</div><!-- /#main-content -->

<?php get_footer(); ?>