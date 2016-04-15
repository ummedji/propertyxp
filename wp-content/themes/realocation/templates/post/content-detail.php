<article id="post-<?php echo the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">

        <h1><?php the_title(); ?> <?php aviators_edit_post_link(); ?></h1>

        <div class="entry-meta">
            <?php aviators_entry_meta(); ?>
        </div><!-- .entry-meta -->
        <?php echo hydra_render_field(get_the_ID(), 'eggsbox', 'default'); ?>
        <?php the_content(); ?>

    </header><!-- .entry-header -->
</article>