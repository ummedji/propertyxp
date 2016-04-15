<li class='fieldset parent <?php if($set->hidden) { print 'hidden-item'; } ?>' id="item_<?php print $set->id; ?>">

  <div class="fieldset-content">
    <div class="fieldset-title">
      <h2>
        <div class="drag"><img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/drag-black.png"></div>
        <?php print $set->field_label; ?>
      </h2>
      <div class="field-name"><?php print $set->getCleanMachineName(); ?></div>

      <div class="inputs actions">

        <a class="edit" href="<?php print $this->createRoute('field', 'edit', array('id' => $set->id, 'post_type' => $post_type, 'field_type' => $set->field_type)); ?>">
          <img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/icon-wheel.png">
        </a>

        <a class="delete" href="<?php print $this->createRoute('field', 'delete', array('id' => $set->id, 'post_type' => $post_type, 'field_type' => $set->field_type)); ?>">
          <img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/icon-trash.png">
        </a>

        <?php print $formOutput['form_fields'][$set->id]['weight']; ?>
        <?php print $formOutput['form_fields'][$set->id]['parent_id']; ?>
        <?php print $formOutput['form_fields'][$set->id]['hidden']; ?>
      </div>

    </div>
  </div>
  <!---->


  <ul class="inner">
    <?php if ($set->hasChildren()): ?>
      <?php foreach ($set->getChildren() as $item): ?>
        <?php $itemFormOutput = $formOutput['form_fields'][$set->id][$item->id]; ?>
        <?php include 'item.tpl.php' ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </ul>
</li>