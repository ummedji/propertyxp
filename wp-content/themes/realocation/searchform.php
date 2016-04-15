<div class="content has-feedback">
	<form method="get" class="form-search site-search" action="<?php echo site_url(); ?>">
		<input class="search-query form-control" placeholder="<?php echo __('Search', 'aviators'); ?>" type="text" name="s" id="s" value="<?php if ( isset($_GET['s']) ): ?><?php echo $_GET['s']; ?><?php endif; ?>">
		<button type="submit" class="form-control-feedback"><i class="fa fa-search"></i></button>
	</form><!-- /.site-search -->
</div><!-- /.inner -->