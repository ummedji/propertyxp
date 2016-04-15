<div class="hydra-page">
    <?php print $title; ?>
    <?php $formOutput = $sortForm->customRender(); ?>

    <?php print $messages; ?>
    <?php print hydra_render_messages(); ?>
    <?php print $formOutput['form_start']; ?>

    <div class="hydra-list">
      <div class="table-content">

        <ul class="hydra-sort acf widefat">
          <?php if (count($items)): ?>
            <?php foreach ($items as $set): ?>
              <?php /** @var HydraFieldRecord $set */ ?>
              <?php if ($set->isWrapper()): ?>
                <?php include 'group.tpl.php'; ?>
              <?php else: ?>
                <?php $item = $set; ?>
                <?php $itemFormOutput = $formOutput['form_fields'][$item->id]; ?>
                <?php include 'item.tpl.php'; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </ul>


        <div class="form-actions">
          <div class="pull-right">
            <?php print $formOutput['form_fields']['token']; ?>
            <?php print $formOutput['form_fields']['post_type']; ?>
            <?php print $formOutput['form_fields']['form_id']; ?>
            <?php print $formOutput['form_fields']['save']; ?>
          </div>
        </div>

        <?php print $formOutput['form_closure']; ?>
      </div>
    </div>

    <?php $addForm->render(); ?>
</div>