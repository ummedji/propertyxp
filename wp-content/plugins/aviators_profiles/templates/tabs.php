<div class="tabs-wrapper">
    <ul id="submission-tabs" class="nav nav-tabs">
        <?php foreach($actions as $action): ?>
            <li class="tab submission-tab <?php if ($action['active']): ?>active<?php endif; ?>">
                <a href="<?php print $action['link']; ?>"><?php print $action['title']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>