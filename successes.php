<?php if(count($successes) > 0) : ?>
	<div class="success">
		<?php foreach ($successes as $success) : ?>
			<p><?php echo $success?></p>
		<?php endforeach ?>
	</div>
<?php endif ?>