<li class="field <?php if($item->hidden) { print 'hidden-item'; } ?>" id="item_<?php print $item->id; ?>">
  <div class="inner">
    <div class="item">
      <div class="drag"><img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/drag-black.png"></div>
      <div class="inner"><?php print $item->field_label; ?></div>
    </div>
    <div class="item">
      <div class="inner"><?php print $item->field_name; ?></div>
    </div>
    <div class="item">
      <div class="inner"><?php print $item->field_type; ?></div>
    </div>

    <div class="item">
      <div class="inner">
        <?php print $item->widget; ?>
      </div>
    </div>
    <div class="item">
      <div class="inner actions">
        <?php print $itemFormOutput['weight']; ?>
        <?php print $itemFormOutput['parent_id']; ?>
        <?php print $itemFormOutput['hidden']; ?>

        <a class="edit" href="<?php print $this->createRoute('field', 'edit', array('id' => $item->id, 'post_type' => $post_type, 'field_type' => $item->field_type)); ?>">
          <img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/icon-wheel.png">
        </a>

        <a class="delete" href="<?php print $this->createRoute('field', 'delete', array('id' => $item->id, 'post_type' => $post_type, 'field_type' => $item->field_type)); ?>">
          <img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/icon-trash.png">
        </a>
      </div>
    </div>
  </div>
</li>