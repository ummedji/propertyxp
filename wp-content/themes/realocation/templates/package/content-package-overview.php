<?php
/**
 * Get active package name - number of properties/agents/agencies + remaining + list of already active ?
 */
$package = aviators_package_get_package_by_user();

if ($package) {
    $data = aviators_package_get_data($package->ID);
}
?>

<?php if (!$package): ?>
    <?php print __('You dont have any active package', 'aviators') ?>
<?php else: ?>

    <?php $package_stats = aviators_package_get_package_data(); ?>
    <table class="table">
        <thead>
            <tr>
                <th><?php echo __('Package Name', 'aviators'); ?></th>
                <th><?php echo __('Status', 'aviators'); ?></th>
                <th><?php echo __('Objects', 'aviators'); ?></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th><?php print __('Properties', 'aviators'); ?></th>
                <td>
                    <span class="label <?php echo count($package_stats['active_properties']) < $data['property'] ? 'label-success' : 'label-warning'; ?>">
                        <?php print count($package_stats['active_properties']) ?>/<?php print $data['property']; ?>
                    </span>
                </td>
                <td>
                    <ol>
                        <?php foreach($package_stats['active_properties'] as $active_property): ?>
                            <li>
                                <a href="<?php print get_permalink($active_property->ID); ?>"><?php print $active_property->post_title; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </td>
            </tr>

            <tr>
                <th><?php print __('Agents', 'aviators'); ?></th>
                <td>
                    <span class="label <?php echo count($package_stats['active_agents']) < $data['agent'] ? 'label-success' : 'label-warning'; ?>">
                        <?php print count($package_stats['active_agents']) ?>/<?php print $data['agent']; ?>
                    </span>
                </td>
                <td>
                    <ol>
                        <?php foreach($package_stats['active_agents'] as $active_agent): ?>
                            <li>
                                <a href="<?php print get_permalink($active_agent->ID); ?>"><?php print $active_agent->post_title; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </td>
            </tr>

            <tr>
                <th><?php print __('Agencies', 'aviators'); ?></th>
                <td>
                    <span class="label <?php echo count($package_stats['active_agencies']) < $data['agency'] ? 'label-success' : 'label-warning'; ?>">
                        <?php print count($package_stats['active_agencies']) ?>/<?php print $data['agency']; ?>
                    </span>
                </td>
                <td>
                    <ol>
                        <?php foreach($package_stats['active_agencies'] as $active_agency): ?>
                            <li>
                                <a href="<?php print get_permalink($active_agency->ID); ?>"><?php print $active_agency->post_title; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>