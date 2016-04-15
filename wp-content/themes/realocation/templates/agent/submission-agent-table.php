<table class="table table-striped">
    <thead>
        <tr>
            <th>
                <?php print __('ID', 'aviators') ?>
            </th>

            <th>
                Image
            </th>

            <th>
                <?php print __('Title', 'aviators') ?>
            </th>
            <th>
                <?php print __('Subtitle', 'aviators') ?>
            </th>
            <th>
                <?php print __('Status', 'aviators') ?>
            </th>
            <th>
                <?php print __('Actions', 'aviators') ?>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php while(have_posts()): ?>
            <?php the_post() ?>
            <tr>
                <?php aviators_get_content_template('agent', 'submission'); ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
