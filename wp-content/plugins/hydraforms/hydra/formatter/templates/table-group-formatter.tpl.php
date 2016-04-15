<div <?php print $attributes; ?>>

    <?php if ($displayTitle): ?>
        <h3>
            <?php print $groupFieldView->getLabel(); ?>
        </h3>
    <?php endif; ?>

    <table id="<?php print $id; ?>" class="table-formatter">
        <?php $count = 0; ?>
        <?php foreach ($fields as $field): ?>
            <tr class="<?php if ($count % 2) {
                print 'odd';
            }
            else {
                print 'even';
            } ?>">
                <?php $count++ ?>
                <td class="item-label">
                    <?php print $field->field->meta->label; ?>
                </td>
                <td class="item-value">
                    <?php print $field->field->meta->markup; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>