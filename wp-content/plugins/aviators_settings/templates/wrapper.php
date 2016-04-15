<div class="aviators">
    <div class="aviators-wrapper clear">
        <h2 class="page-title">
            <?php print $definition['title']; ?>
        </h2>
        <div class="aviators-main">
            <div class="aviators-sidebar">
                <?php include 'tabs.php'; ?>
            </div>

            <div class="aviators-content">
                <?php $form->render(); ?>
            </div>
        </div>
    </div>
    <!-- /.aviators-wrapper -->
</div>
<!-- /.aviators -->