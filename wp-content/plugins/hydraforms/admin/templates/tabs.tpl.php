<div class="wrap">
	<div class="tabs tabs-hydra">
	  <ul class="fields">
		<li>
		  <?php print $this->createLink($tabs['fields']['title'], $tabs['fields']['link']); ?>

		</li>
		<li><?php print $this->createLink($tabs['manage_views']['title'], $tabs['manage_views']['link']); ?>
		</li>
	  </ul>

	  <ul class="views">
		<?php foreach ($tabs['views'] as $tab): ?>
		  <li>
			<?php print $this->createLink($tab['title'], $tab['link']) ?>
		  </li>
		<?php endforeach; ?>
	  </ul>
	</div>
</div><!-- /.wrap -->
