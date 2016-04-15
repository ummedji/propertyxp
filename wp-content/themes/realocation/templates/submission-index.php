<?php aviators_submission_messages($post_type); ?>
<?php echo aviators_render_messages(); ?>
<?php if (is_user_logged_in()) : ?>
    <?php $current_user = wp_get_current_user(); ?>
    <?php $link = aviators_submission_add($post_type); ?>
    <?php the_post(); ?>

    <h2>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <?php echo aviators_edit_post_link(); ?>
        <a href="<?php echo $link['link']; ?>" class="pull-right <?php echo $link['btn_class']; ?>"> <i class="<?php echo $link['icon_class']; ?>"></i> <?php echo $link['text']; ?></a>
    </h2>

    <?php the_content(); ?>

    <?php aviators_submission_tabs(); ?>

    <?php
    $paged = 1;
    if(get_query_var('paged')) {
      $paged = get_query_var('paged');
    }

    query_posts(array(
        'post_type' => $post_type,
        'post_status' => 'any',
        'author' => $current_user->ID,
        'paged' => $paged,
    ));

    ?>

    <?php if (have_posts()): ?>
        <?php aviators_get_template('submission', $post_type, 'table'); ?>
    <?php endif; ?>
    <?php aviators_pagination(); ?>
    <?php wp_reset_query(); ?>
<?php endif; ?>