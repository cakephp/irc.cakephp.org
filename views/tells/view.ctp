<?php /* SVN FILE: $Id$ */ ?>
<div class="tells view">
<h2><?php  __('Tell');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tell['Tell']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Keyword'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tell['Tell']['keyword']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tell['Tell']['message']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tell['Tell']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tell['Tell']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Tell', true), array('action'=>'edit', $tell['Tell']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Tell', true), array('action'=>'delete', $tell['Tell']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tell['Tell']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Tells', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tell', true), array('action'=>'add')); ?> </li>
	</ul>
</div>