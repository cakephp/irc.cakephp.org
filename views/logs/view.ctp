<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link			http://www.cakefoundation.org/projects/info/cakebot
 * @package			$TM_DIRECTORY
 * @subpackage		$TM_DIRECTORY
 * @since			$TM_DIRECTORY v (1.0)
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Tells controller
 *
 *
 * @package		cakebot
 * @subpackage	cakebot.views.channels
 */
?>
<?php   // to someone wants to add url highlighting, this is my standard regular expression for urls ^((ht|f)tp(s?)\:\/\/|~/|/)?([\w]+:\w+@)?([a-zA-Z]{1}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?((/?\w+/)+|/?)(\w+\.[\w]{3,4})?((\?\w+=\w+)?(&\w+=\w+)*)? ?>
<div class="logs index">
<h2><?php __('Logs');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th class="actions"><?php __('Report');?></th>
	<th class="channel"><?php echo $paginator->sort('channel');?></th>
	<th class="at"><?php echo $paginator->sort('At', 'created');?></th>
	<th class="username"><?php echo $paginator->sort('username');?></th>
	<th class="text"><?php echo $paginator->sort('text');?></th>
</tr>
<?php
$i = 0;
foreach ($logs as $log):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $html->link(__('Report', true), array('action'=>'report', $log['Log']['id']), null, sprintf(__('Are you sure you want to report this message?', true))); ?>
		</td>
		<td>
			<?php echo $log['Log']['channel']; ?>
		</td>
		<td>
			<?php echo $time->format("H:i:s", $log['Log']['created']); ?>
		</td>
		<td>
			<?php echo $log['Log']['username']; ?>
		</td>
		<td class="log-text">
			<?php echo $log['Log']['text']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php $paginator->options(array('url' => $this->passedArgs)); ?>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>