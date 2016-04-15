<div id="<?php print $id; ?>" class="<?php print $classes; ?>">
	<div class="wrapper">
		<div class="inner">
			<?php if ($title_enable): ?>
				<div class="title">
					<div class="title-inner">
						<h2><?php print $formRecord->getLabel(); ?></h2>
					</div><!-- /.title-inner -->
				</div>
			<?php endif;?>

			<div class="hydra-form-content">
				<div class="hydra-form-content-inner">
					<?php $form->render(); ?>
				</div><!-- /.hydra-form-content-inner -->
			</div><!-- /.hydra-form-content -->
		</div><!-- /.inner -->
	</div><!-- /.wrapper -->
</div>
