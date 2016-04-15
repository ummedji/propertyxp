<?php
/**
 * Template Name: Property Submission Index
 */
?>
<?php aviators_submission_permission_check(); ?>
<?php aviators_transaction_configuration_set(); ?>

<?php get_header(); ?>
<?php aviators_submission_process_actions(); ?>

<div id="main-content" class="col-md-12">
    <?php dynamic_sidebar( 'content-top' ); ?>

    <?php $post_type = "property"; ?>
    <?php aviators_get_template('submission', 'property', 'index'); ?>
    <?php dynamic_sidebar( 'content-bottom' ); ?>
</div>

<?php get_footer(); ?>