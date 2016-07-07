<style>
    #hydraform-properties_horizontal{
        background-color: #ffffff;
        padding: 10px;
    }
    #hf-property-starting-price-filter-1{
        margin-bottom: 15px !important;
    }
    #hf-property-type-filter{
        background-color: #bf224e;
    }
    #hf-property-contract-type-filter{
        width: 19.28% !important;
    }
    #hf-property-location-filter .field-type-select{
        width: 33.33% !important;
    }
    #hf-property-location-filter{
        width: 61.84% !important;
        margin-left: 20em;
        margin-top: -34px;
    }
    .field-type-submit{
        width: 13.28% !important;
        float: right !important;
        margin-top: -55px !important;

    }
    #hydra-submit{
        padding: 6px 0px;
    }
    @media screen and (min-width: 768px) and (max-width: 991px) {
        #hf-property-location-filter{
            margin-left: 12em !important;
        }
    }

    @media screen and (min-width: 992px) and (max-width: 1200px) {
        #hf-property-location-filter{
            margin-left: 16em;
        }
    }

    @media screen and (max-width: 767px) {
        #hf-property-contract-type-filter {
            width: 100% !important;
        }
        #hf-property-location-filter {
            width: 100% !important;
             margin-left: inherit;
             margin-top: inherit;
        }
        #hf-property-location-filter .field-type-select{
            margin: 10px 0px;
            width: 100% !important;
        }
        .field-type-submit {
            width: 100% !important;
            float: inherit;
            margin-top: 0px !important;
        }
    }


</style>
<?php $renderer->renderStart(); ?>
<?php $renderer->render(); ?>
<?php $renderer->renderClose(); ?>
<?php /* $renderer->renderStart(); ?>
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

<?php $renderer->renderClose(); */?>