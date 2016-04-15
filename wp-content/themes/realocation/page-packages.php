<?php
/**
 * Template Name: Packages
 */
?>
<?
$query_args = array(
    'post_type' => 'property',
    'paged' => $paged,
    'posts_per_page' => -1,
);

$query_args = array();

$sorted_packages = aviators_settings_get('package', get_the_ID(), 'weight');

if(is_array($sorted_packages) && count($sorted_packages)) {
    arsort($sorted_packages);

    $sorted_packages = array_reverse($sorted_packages, true);
} else {
    $sorted_packages = array();
}

global $post;
$packages = get_posts(array('post_type' => 'package'));

if(is_array($packages) && count($packages)) {
    foreach($packages as $package) {
        // event if not set, we will place it !
        $sorted_packages[$package->ID] = $package;
    }
}

$number = aviators_settings_get('package', get_the_ID(), 'number');
switch($number) {
    case 3:
        $col_class = 'col-sm-4';
        break;
    case 4:
    default:
        $col_class = 'col-sm-3';
}

if(aviators_settings_get('package', get_the_ID(), 'merged')) {
    $class = 'merged';
} else {
    $class = 'not-merged';
}

$title_class = 'left';
if(aviators_settings_get('package', get_the_ID(), 'title_position')) {
    $title_class = aviators_settings_get('package', get_the_ID(), 'title_position');
}


$page_id = get_the_ID();
the_post();
?>

<?php get_header(); ?>
    <div id="main-content" class="<?php if ( is_active_sidebar( 'sidebar-1' ) && !aviators_settings_get('package', get_the_ID(), 'disable_sidebar') ) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">

        <?php if (dynamic_sidebar('content-top')) : ?><?php endif; ?>
        <div class="clearfix">
        <h1 class="<?php echo $title_class; ?>">
            <?php the_title(); ?>
            <?php aviators_edit_post_link(); ?>
            <?php aviators_configure_page_link('package', get_the_ID()) ?>
        </h1>
        </div>

        <?php the_content() ?>


        <div class="row">
            <div class="pricing-cols <?php echo $class; ?>">

                <?php if(count($sorted_packages)): ?>
                    <?php foreach($sorted_packages as $package): ?>

                        <?php $post = $package; ?>
                        <?php setup_postdata( $post ); ?>

                        <div class="pricing-col-wrapper <?php print $col_class ?>">
                            <?php aviators_get_content_template('package'); ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php echo __('No packages set for this page', 'aviators'); ?>
                <?php endif; ?>

            </div><!-- /.items-list -->
        </div>

        <?php if (dynamic_sidebar('content-bottom')) : ?><?php endif; ?>
    </div><!-- /#main-content -->

    <?php if ( is_active_sidebar( 'sidebar-1' ) && !aviators_settings_get('package', $page_id, 'disable_sidebar') ): ?>
        <div class="sidebar col-md-3 col-sm-3">
            <?php get_sidebar( 'sidebar-1' ); ?>
        </div><!-- /#sidebar -->
    <?php endif; ?>


<?php get_footer(); ?>