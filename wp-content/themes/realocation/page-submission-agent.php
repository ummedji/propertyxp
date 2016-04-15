<?php
/**
 * Template Name: Agent Submission Form
 */
?>
<?php aviators_submission_permission_check(); ?>
<?php get_header(); ?>

<div id="main-content" class="col-md-12">
    <?php if (dynamic_sidebar('content-top')) : ?><?php endif; ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php get_template_part( 'content', 'simple' ); ?>
    <?php endwhile; ?>

    <?php
    $id = NULL;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }

    $form = hydra_get_frontend_submission($id, 'agent');
    $renderer = new HydraAdvancedRender($form);

    ?>
    <?php $renderer->renderStart(); ?>

    <div class="row">


        <div class="col-md-3 col-md-push-9">
            <div class="box">
                <?php $renderer->renderField('thumbnail_title'); ?>
                <?php $renderer->renderField('thumbnail'); ?>
                <?php $renderer->renderField('delete_thumbnail'); ?>
                <?php $renderer->renderField('thumbnail_markup'); ?>
            </div>

            <h3><i class="fa fa-group"></i><?php print __('Social', 'aviators'); ?></h3>
            <div class="box">
                <?php $renderer->renderField('hf_agent_social'); ?>
            </div>
        </div>

        <div class="col-md-9 col-md-pull-3">
            <?php $renderer->renderField('post_title'); ?>
            <?php $renderer->renderField('post_content'); ?>


            <?php
            ob_start();
            $renderer->renderField('save');
            $save_button = ob_get_clean();

            ob_start();
            $renderer->renderField('agreement');
            $agreement = ob_get_clean();
            ?>

            <div class="box">
                <?php // render rest of the fields which were not  rendered so far ?>
                <?php $renderer->render(); ?>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php $tos = aviators_submission_get_tos('agent'); ?>
                <?php if($tos): ?>
                    <?php print $agreement; ?>
                    <div id="legal-agreement" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h3 id="myModalLabel"><?php echo $tos->post_title; ?></h3>
                                </div>
                                <div class="modal-body">
                                    <?php echo do_shortcode($tos->post_content); ?>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn" data-dismiss="modal" aria-hidden="true"> <?php echo __('Close', 'aviators'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <?php print $save_button; ?>
            </div>
        </div>
    </div>

    <?php if (dynamic_sidebar('content-bottom')) : ?><?php endif; ?>
</div><!-- /#main-content -->

<?php get_footer(); ?>