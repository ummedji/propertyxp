<?php ?>

<table>
    <tr>
        <th>
            <?php print __('Title', 'aviators'); ?>
        </th>
        <td><a href="<?php get_permalink($post->post_ID); ?>"><?php print $post->post_title; ?></a></td>
    </tr>
    <tr>
        <th>
            <?php print __('Post Type', 'aviators'); ?>
        </th>
        <td>
            <?php print  $post->post_type; ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php print __('Status', 'aviators'); ?>
        </th>
        <td>
            <?php print $post->post_status; ?>
        </td>
    </tr>
    <tr>
        <th>
            <?php print __('Author', 'aviators'); ?>
        </th>
        <td>
            <?php print get_the_author_meta('display_name'); ?>
        </td>
    </tr>
</table>