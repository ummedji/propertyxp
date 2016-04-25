<?php
    // $renderer->renderStart() is always required, it echoes the basic form element
    // $renderer->renderField($field_name) render specific field, $field_name is machine name which can be seen in the filter administration pages
    // $renderer->render() renders all remaining fields
    // $renderer->renderClose() closes the form, needs to be always called
?>
<?php $renderer->renderStart(); ?>
    <div class="row background-primary">
        <div class="col-sm-12">
            <?php echo $renderer->renderField('hf_property_type_filter'); ?>
        </div>
    </div>

    <div class="row background-white filter-horizontal-padding as_filter-horizontal-padding">
        <!-- <div class="col-sm-3">
            <?php //echo $renderer->renderField('hf_property_price_filter'); ?>
        </div> -->
        <div class="col-sm-4 as_col_col_sm_4">
            <?php echo $renderer->renderField('hf_property_minimum_price_filter'); ?>
        </div>
        <div class="col-sm-4 as_col_col_sm_4">
            <?php echo $renderer->renderField('hf_property_maximum_price_filter'); ?>
        </div> 
        <div class="col-sm-4 as_col_col_sm_4">
            <?php echo $renderer->renderField('hf_property_contract_type_filter'); ?>
        </div>
        
        

        <div class="col-sm-10 as_col_col_sm_6">
            <?php echo $renderer->renderField('hf_property_location_filter'); ?>
        </div>
        <?php if(is_page('map-mode')) {?>
		<div class="col-sm-12">
			<?php echo $renderer->renderField('hf_property_location_filter_2'); ?>
        </div>
        <div class="col-sm-12">
        	<?php $renderer->render(); ?>
        </div>
        <?php } ?>
        
        <div class="col-sm-2 as_col_col_sm_4 search_bt">
            <?php $renderer->renderField('submit'); ?>
        </div>
        
        
        

        
    </div>

<?php $renderer->renderClose(); ?>