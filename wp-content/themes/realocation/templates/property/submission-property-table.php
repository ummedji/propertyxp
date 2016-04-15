
<table class="table table-striped">
    <thead>
        <tr>
            <th>
                <?php print __('ID', 'aviators') ?>
            </th>
            <th>
                <?php print __('Picture', 'aviators'); ?>
            </th>
            <th>
                <?php print __('Address', 'aviators'); ?>
            </th>
            <th>
                <?php print __('Price', 'aviators'); ?>
            </th>
            <th>
                <?php print __('Type', 'aviators'); ?>
            </th>
            <th>
                <?php print __('Status', 'aviators'); ?>
            </th>
            <th>
                <?php print __('Actions', 'aviators'); ?>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php while(have_posts()): ?>
            <?php the_post() ?>
            <tr>
                <?php aviators_get_content_template('property', 'submission'); ?>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
