<div class="tabs-wrapper">
    <ul id="profile-tabs" class="nav nav-tabs">
        <?php foreach($tabs as $tab): ?>
            <li class="tab profile-tab <?php if (get_the_ID() == $tab['page']->ID): ?>active<?php endif; ?>">
                <a href="<?php print get_permalink($tab['page']->ID); ?>"><?php print $tab['title']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>