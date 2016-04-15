<table>
    <tr>
        <?php foreach ($fields as $field): ?>
            <td>
                <?php print $field->markup; ?>
            </td>
        <?php endforeach; ?>
    </tr>
</table>