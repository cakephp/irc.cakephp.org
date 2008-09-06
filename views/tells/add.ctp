<?php /* SVN FILE: $Id$ */ ?>
<div class="tells form">
<?php echo $form->create('Tell');?>
	<fieldset>
 		<legend><?php __('Add Tell');?></legend>
	<?php
		echo $form->input('keyword');
		echo $form->input('message');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Tells', true), array('action'=>'index'));?></li>
	</ul>
</div>