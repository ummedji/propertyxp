<?php echo $formRender['form_start']; ?>
<table>
    <tbody>
        <?php foreach($plugins as $index => $plugin): ?>
            <tr>
                <td>
                    <?php echo $plugin['title']; ?>
                </td>
                <td>
                    <?php echo $formRender['form_fields'][$index]['update']; ?>
                    <?php echo $formRender['form_fields'][$index]['revert']; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php echo $formRender['form_fields']['update_all']; ?>
<?php echo $formRender['form_fields']['revert_all']; ?>

<?php echo $formRender['form_fields']['token']; ?>
<?php echo $formRender['form_fields']['form_id']; ?>
<?php echo $formRender['form_closure']; ?>
