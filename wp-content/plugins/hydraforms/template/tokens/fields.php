<?php foreach($fields as $field_name => $field): ?>
    <tr>
        <td colspan="3">
            <div class="expander">
                <div class="switch closed"></div>
                <strong><?php print $field['title']; ?></strong>
            </div>
            <?php if(isset($field['tokens'])): ?>
                <?php $tokens = $field['tokens'] ?>
                <table style="display: none;">
                    <?php include 'list.php'; ?>
                </table>
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach; ?>