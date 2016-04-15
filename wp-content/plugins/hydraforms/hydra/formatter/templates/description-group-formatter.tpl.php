<div <?php print $attributes; ?>>
    <?php if ($displayTitle): ?>
        <h3>
            <?php print $groupFieldView->getLabel(); ?>
        </h3>
    <?php endif; ?>
    <dl>
        <?php $count = 0; ?>
        <?php foreach ($fields as $field): ?>
            <?php $count++ ?>
            <dt class="item-label">
                <?php print $field->field->meta->label; ?>
            </dt>
            <dd class="item-value">
                <?php print $field->field->meta->markup; ?>
            </dd>
        <?php endforeach; ?>
    </dl>
</div>
