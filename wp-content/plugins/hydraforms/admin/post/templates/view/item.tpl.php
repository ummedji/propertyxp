<li class="field <?php if($item->hidden) { print 'hidden-item'; } ?>" id="item_<?php print $item->id; ?>">

  <div class="inner">
    <div class="item">
      <div class="drag"><img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/drag-black.png"></div>
      <div class="inner"><?php print $item->field->field_label; ?></div>
    </div>
    <div class="item">
      <div class="inner"><?php print $item->field->field_name; ?></div>
    </div>
    <div class="item">
      <div class="inner"><?php print $item->field->field_type; ?></div>
    </div>

    <div class="item" style="width: 25%">
      <div class="inner actions">

        <?php print $itemFormOutput['formatter']; ?>
        <?php print $itemFormOutput['weight']; ?>
        <?php print $itemFormOutput['parent_id']; ?>
        <?php print $itemFormOutput['hidden']; ?>

        <a id="hide-<?php print $item->id; ?>" class="hide-action" href="#">
          <img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/icon-eye.png">
        </a>

        <a id="settings-<?php print $item->id; ?>" class="settings-action" href="#">
          <img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/icon-wheel.png">
        </a>
      </div>
    </div>
  </div>

  <div class="formatter-settings formatter-settings-field">
    <?php print $formatterSettings[$item->id]; ?>
  </div>
</li>