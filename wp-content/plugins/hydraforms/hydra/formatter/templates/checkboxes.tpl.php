<div class="row">
<?php foreach ($chunks as $chunk): ?>
    <div class="<?php print $columns_class; ?>">
        <div class="inner">
            <ul>
                <?php foreach ($chunk as $key => $option): ?>
                    <li>
                      <i class="<?php if (in_array($key, $value)) { print "fa fa-check ok"; } else { print "fa fa-ban no"; } ?>"></i>
                    <?php print $option; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endforeach; ?>
</div>