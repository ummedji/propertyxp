<?php $renderer->renderStart(); ?>
    <div class="row background-primary">
        <div class="col-sm-12">
            <?php echo $renderer->renderField('hf_property_type_filter'); ?>
        </div>
    </div>

    <div class="row background-white filter-horizontal-padding">

        <div class="col-sm-3">
            <?php echo $renderer->renderField('hf_property_price_filter'); ?>
        </div>

        <div class="col-sm-7">
            <?php echo $renderer->renderField('hf_property_location_filter'); ?>
        </div>

        <div class="col-sm-2">
            <?php $renderer->render(); ?>
        </div>
    </div>

<?php $renderer->renderClose(); ?>