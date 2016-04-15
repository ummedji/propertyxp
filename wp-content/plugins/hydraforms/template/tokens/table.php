<h4><?php echo $context['title']; ?></h4>

<table class="token-table">
    <thead>
        <tr>
            <td><?php echo  __('Name', 'hydraforms'); ?></td>
            <td><?php echo  __('Token', 'hydraforms'); ?></td>
            <td><?php echo  __('Description', 'hydraforms'); ?></td>
        </tr>
    </thead>

    <?php if(isset($context['tokens'])): ?>
        <?php $tokens = $context['tokens'] ?>
        <?php include 'list.php'; ?>
    <?php endif; ?>
    <?php include 'fields.php'; ?>
</table>