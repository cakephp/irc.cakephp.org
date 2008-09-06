<?php /* SVN FILE: $Id$ */ ?>
<div class="tells index">
<h2><?php __('Tells');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('keyword');?></th>
	<th><?php echo $paginator->sort('message');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($tells as $tell):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $tell['Tell']['id']; ?>
		</td>
		<td>
			<?php echo $tell['Tell']['keyword']; ?>
		</td>
		<td>
			<?php echo $tell['Tell']['message']; ?>
		</td>
		<td>
			<?php echo $tell['Tell']['created']; ?>
		</td>
		<td>
			<?php echo $tell['Tell']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $tell['Tell']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $tell['Tell']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $tell['Tell']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tell['Tell']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Tell', true), array('action'=>'add')); ?></li>
	</ul>
</div>