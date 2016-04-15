<?php
    $sorted_packages = aviators_settings_get('package', 'archive', 'weight');
    arsort($sorted_packages);
    $sorted_packages = array_reverse($sorted_packages, true);

    global $post;
    $packages = get_posts(array('post_type' => 'package'));

    foreach($packages as $package) {
        // event if not set, we will place it !
        $sorted_packages[$package->ID] = $package;
    }

    $number = aviators_settings_get('package', 'archive', 'number');
    switch($number) {
        case 3:
            $col_class = 'col-sm-4';
            break;
        case 4:
        default:
            $col_class = 'col-sm-3';
    }

    if(aviators_settings_get('package', 'archive', 'merged')) {
        $class = 'merged';
    } else {
        $class = 'not-merged';
    }
?>

<h1><?php echo aviators_settings_get('package', 'archive', 'title'); ?></h1>
<div class="row">
    <div class="pricing-cols <?php echo $class; ?>">
        <?php foreach($sorted_packages as $package): ?>

            <?php $post = $package; ?>
            <?php setup_postdata( $post ); ?>

            <div class="pricing-col-wrapper <?php print $col_class ?>">
                <?php aviators_get_content_template('package'); ?>
            </div>
        <?php endforeach; ?>
    </div><!-- /.items-list -->
</div>

<?php print aviators_pagination(); ?>