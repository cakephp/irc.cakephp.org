<?php /* SVN FILE: $Id$ */ ?>
<div class="tells form">
<?php echo $form->create('Tell');?>
	<fieldset>
 		<legend><?php __('Edit Tell');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('keyword');
		echo $form->input('message');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Tell.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Tell.id'))); ?></li>
		<li><?php echo $html->link(__('List Tells', true), array('action'=>'index'));?></li>
	</ul>
</div>