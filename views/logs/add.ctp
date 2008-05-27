<div class="logs form">
<?php echo $form->create('Log');?>
	<fieldset>
 		<legend><?php __('Add Log');?></legend>
	<?php
		echo $form->input('channel');
		echo $form->input('username');
		echo $form->input('text');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Logs', true), array('action'=>'index'));?></li>
	</ul>
</div>
