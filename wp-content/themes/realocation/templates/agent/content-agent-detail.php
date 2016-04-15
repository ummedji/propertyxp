<div class="agent-detail">

    <div class="row">
        <div class="col-sm-12">
            <h1>
                <?php the_title() ?>
            </h1>
        </div>

        <div class="col-sm-3">
            <div class="agent-detail-picture">
                <img src="<?php echo aviators_get_featured_image(get_the_ID(), 284, 284); ?>" alt="<?php the_title(); ?>">
            </div>
            <!-- /.agent-detail-picture -->
        </div>

        <div class="col-sm-8">
            <?php print hydra_render_group(get_the_ID(), 'contact_information', 'detail'); ?>
            <div class="block-content">
                <?php the_content(); ?>
            </div>
            <?php print hydra_render_field(get_the_ID(), 'social', 'detail'); ?>
            <!-- /.social-->
        </div>
    </div>
    <!-- /.row -->
</div>

<?php print hydra_render_field(get_the_ID(), 'properties', 'default'); ?>

<?php $manager = new HydraFormManager('contact_agent'); ?>
<?php $formBuild = $manager->buildForm(); ?>
<?php $formBuild->addField('hidden', array('tokens', get_the_ID())); ?>
<?php $formRenderer = new HydraAdvancedRender($formBuild); ?>
<?php list($form, $form_title, $classes) = hydra_render_form('contact_agent', true, array(get_the_ID())); ?>

<?php if($form_title): ?>
    <h2><?php print $form_title; ?></h2>
<?php endif; ?>

<div class="<?php print $classes; ?> box">
    <?php $formRenderer->renderStart(); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php $formRenderer->renderField('hf_contact_agent_name'); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php $formRenderer->renderField('hf_contact_agent_mail'); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?php $formRenderer->renderField('hf_contact_agent_message'); ?>
    </div>
    <div class="form-group">
        <?php $formRenderer->renderField('submit'); ?>
    </div>

    <?php $formRenderer->render();?>
    <?php $formRenderer->renderClose();?>
</div>