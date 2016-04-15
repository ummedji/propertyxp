<?php $counter = 0; ?>
<?php foreach ($tokens as $token): ?>
    <?php $counter++ ?>
    <?php $row = $counter % 2 ?>

    <tr class="<?php echo empty($row) ? "odd" : "even" ?>">
        <td style="width: 30%">
            <?php echo $this->createTokenLink($type, $token['name'], $token['title']); ?>
        </td>
        <td style="width: 30%">
            <?php echo $this->createTokenId($type, $token['name']); ?> <br/>
        </td>
        <td style="width: 40%">
            <div class="token-description">
                <?php if(isset($token['description'])): ?>
                    <?php echo $token['description']; ?>
                <?php endif; ?>
            </div>
        </td>
    </tr>
<?php endforeach; ?>