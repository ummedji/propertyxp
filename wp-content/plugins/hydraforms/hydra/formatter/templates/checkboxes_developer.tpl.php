
<?php foreach ($chunks as $chunk): ?>
    
                <?php foreach ($chunk as $key => $option):
                		 if (in_array($key, $value)) {?>
		                 
		                    <?php if($option == 'Lift' || $option == 'Security' || $option == 'Internet' || $option == 'Play Area' || $option == 'Swimming Pool' || $option == 'Gymnasium' ||
		                    		$option == 'Garden' || $option == 'Library' || $option == 'Community Hall' || $option == 'Internal Roads' || $option == 'Jogging Track' || 
		                    		$option == 'No Power Backup') {?>
		                    
		                    <?php print $option.','; ?>
		                    <?php } ?> 
                	<?php } 
                	endforeach; ?>

<?php endforeach; ?>