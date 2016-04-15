<?php
$display = "row";
if (isset($_GET['display'])) {
    $display = $_GET['display'];
}
else {
    $display = aviators_settings_get('agent', 'archive', 'display_type');
}

$fullwidth = !is_active_sidebar('sidebar-1');
switch ($display) {
    case "row":
        $class = empty($fullwidth) ? "col-sm-6" : "col-sm-4";
        break;
    case "grid":
        $class = empty($fullwidth) ? "col-sm-4" : "col-sm-3";
        break;
    default:
        $class = 'post col-sm-12';
        break;
}


$resolutions = array(
    'xs' => 1,
    'sm' => 2,
    'md' => 3,
    'lg' => 3,
);

if ($fullwidth) {
    $resolutions = array(
        'xs' => 1,
        'sm' => 2,
        'md' => 4,
        'lg' => 4,
    );
}
?>

<div class="items-list row">
    <?php $count = 1; ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $end_line = '';
        if ($display == 'grid') {
            foreach ($resolutions as $resolution => $columns) {
                if ($count % (12 / $columns) == 0) {
                    $end_line .= ' new-line-' . $resolution;
                }
            }
        }
        ?>

        <div class="<?php print $class; ?> <?php print $end_line; ?>">
            <?php aviators_get_content_template('agent', $display); ?>
        </div>
        <?php $count++; ?>
    <?php endwhile; ?>
</div><!-- /.items-list -->