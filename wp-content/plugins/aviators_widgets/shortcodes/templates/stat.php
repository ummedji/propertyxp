<div class="block-stats background-dots background-primary color-white">
    <?php if(!empty($number)): ?>
    <strong><?php print $number;?></strong>
    <?php endif;?>
    <div class="stat-content">
        <?php print do_shortcode($content); ?>
    </div>
</div><!-- /.block-stats -->
