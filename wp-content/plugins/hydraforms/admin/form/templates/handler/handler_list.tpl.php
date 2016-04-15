<div class="hydra-page">
    <?php print $title; ?>
    <?php print $messages; ?>
    <?php print $tabs; ?>
    <?php print hydra_render_messages(); ?>
    <?php $formOutput = $sortForm->customRender(); ?>

    <?php print $formOutput['form_start']; ?>
      <div class="hydra-list">
        <div class="table-content">

          <ul class="hydra-sort acf widefat">
            <?php if (count($items)): ?>
              <?php foreach ($items as $item): ?>

                <li class="field" id="item_<?php print $item->id; ?>">
                  <div class="inner">
                    <div class="item">
                      <div class="drag"><img
                          src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/drag-black.png"></div>
                      <div class="inner"><?php print $item->label; ?></div>
                    </div>

                    <div class="item">
                      <div class="inner"><?php print $item->type; ?></div>
                    </div>

                    <div class="item">
                      <div class="inner">
                        <?php print $formOutput['form_fields'][$item->id]['weight']; ?>

                        <a class="edit" href="<?php print $this->createRoute(
                          'handler',
                          'edit',
                          array('id' => $item->id, 'post_type' => $post_type, 'type' => $item->type)
                        ); ?>">
                          <img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/icon-wheel.png">
                        </a>

                        <a class="delete" href="<?php print $this->createRoute(
                          'handler',
                          'delete',
                          array('id' => $item->id, 'post_type' => $post_type)
                        ); ?>">
                          <img src="<?php print get_site_url(); ?>/wp-content/plugins/hydraforms/assets/img/icon-trash.png">
                        </a>
                      </div>
                    </div>
                  </div>
                </li>
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