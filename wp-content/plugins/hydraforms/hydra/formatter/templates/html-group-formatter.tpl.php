<div <?php print $attributes; ?>>

    <?php if ($displayTitle): ?>
        <h3>
            <?php print $groupFieldView->getLabel(); ?>
        </h3>
    <?php endif; ?>
    <div class="field-items">
        <?php foreach ($fields as $field): ?>
            <div class="group-field-item">
                <div class="field-item-inner">
                    <?php print $field->field->meta->output; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>