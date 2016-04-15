<div class="property-detail">
    <div class="row">
        <div class="col-md-12">
            <h1 class="property-detail-title"><?php the_title(); ?></h1>

            <div class="property-detail-subtitle"><?php print hydra_render_field(get_the_ID(), 'location', 'detail'); ?>
                <?php print hydra_render_field(get_the_ID(), 'price', 'detail'); ?>
            </div>
        </div>
        <!-- /.header-title -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <?php print hydra_render_field(get_the_ID(), 'gallery', 'detail'); ?>
        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-4">
            <?php print hydra_render_group(get_the_ID(), 'overview', 'detail'); ?>
        </div>
        <div class="col-md-8">
            <?php $content = get_the_content(); ?>
            <?php if (!empty($content)) : ?>
                <h2><?php echo __('Description', 'aviators'); ?></h2>
                <?php the_content(); ?>
            <?php endif; ?>
        </div>
    </div>
    <hr/>
    <?php print hydra_render_field(get_the_ID(), 'related', 'detail'); ?>
    <?php $presentation = hydra_render_group(get_the_ID(), 'presentation', 'detail'); ?>

    <?php if ($presentation): ?>
        <div class="row">
            <div class="col-md-12"><h2><?php echo __('Presentation', 'aviators'); ?></h2></div>
            <?php print $presentation; ?>
        </div>
        <hr/>
    <?php endif; ?>


    <?php $amenities = hydra_render_field(get_the_ID(), 'amenities', 'detail'); ?>
    <?php if ($amenities): ?>
        <div class="row">
            <div class="col-md-12"><h2><?php echo __('Amenities', 'aviators'); ?></h2></div>
            <div class="property-detail-amenities">
                <?php print $amenities; ?>
            </div>
        </div>
    <?php endif; ?>

</div>