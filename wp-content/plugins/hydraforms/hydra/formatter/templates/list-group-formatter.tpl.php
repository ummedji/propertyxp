<div <?php print $attributes; ?>>
    <?php if (!empty($displayTitle)): ?>
        <h3><?php print $groupFieldView->getLabel(); ?></h3>
    <?php endif; ?>

    <ul class="field-items">
        <?php foreach ($fields as $field): ?>
            <li class="group-field-item">
                <div class="field-item-inner">
                    <?php print $field->field->meta->output; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>