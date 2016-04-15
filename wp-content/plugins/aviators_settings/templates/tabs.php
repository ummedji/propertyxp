<h2 class="nav-tab-wrapper">
    <?php foreach($tabs as $slug => $tab): ?>
        <a href="?page=<?php print $page ?>&tab=<?php print $slug ?>" class="nav-tab <?php if($active_tab == $slug): ?> active <?php endif; ?>">
            <?php print $tab['title']; ?>
        </a>
    <?php endforeach; ?>
</h2>
