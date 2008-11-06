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
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakebot
 * @package       cakebot
 * @subpackage    cakebot
 * @since         cakebot v (1.0)
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Tells controller
 *
 *
 * @package       cakebot
 * @subpackage    cakebot.views.channels
 */
?>
<?php   // to someone wants to add url highlighting, this is my standard regular expression for urls ^((ht|f)tp(s?)\:\/\/|~/|/)?([\w]+:\w+@)?([a-zA-Z]{1}([\w\-]+\.)+([\w]{2,5}))(:[\d]{1,5})?((/?\w+/)+|/?)(\w+\.[\w]{3,4})?((\?\w+=\w+)?(&\w+=\w+)*)? ?>
<div class="logs index">
<?php if ($this->action == 'index') {
	echo '<h2>' . $this->passedArgs[0] . ' ' . sprintf(__('%s Logs', true), $this->passedArgs[0]) . '</h2>';
} else {
	echo '<h2>'. sprintf(__('Log message #%s', true), $this->passedArgs[0]) . '</h2>';
}
$paginator->options(array('url' => $this->passedArgs));
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
/**
 *  Use the request time to determine if the user is on a different time zone from the server, and if so,
 *  Determine to the nearest 1/2 hour what their offset is, and use that to display times
 */
if (isset($_SERVER['REQUEST_TIME'])) {
	$offset =  sprintf('%01.0f', (($_SERVER['REQUEST_TIME'] - $time->gmt()) / 1800)) * 2;
} else {
	$offset = null;
}
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th class="at"><?php echo $paginator->sort('#', 'id');?></th>
	<th class="at"><nobr><?php echo $paginator->sort('At', 'created');?></nobr></th>
	<th class="username"><?php echo $paginator->sort('username');?></th>
	<th class="text"><?php echo $paginator->sort('text');?></th>
	<th class="actions"><?php __('Report');?></th>
</tr>
<?php
if (!isset($highlight)) {
	$highlight = $wrap = false;
}
$i = 0;
foreach ($logs as $log):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	if ($log['Log']['id'] == $highlight) {
		$class = ' class="highlight"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php
		if ($log['Log']['id'] == $highlight) {
			echo $html->link('#', '#message' . $log['Log']['id'], array(
				'id' => 'message' . $log['Log']['id'],
				'title' => 'direct link to: ' .	$log['Log']['text'])
			);
		} else {
			echo $html->link('#', array('action' => 'link', $log['Log']['id'], $wrap, '#' => 'message' . ($log['Log']['id'] + 10)), array(
				'id' => 'message' . $log['Log']['id'],
				'title' => 'direct link to: ' .	htmlentities($log['Log']['text']))
			);
		}
		?></td>
		<td nowrap="true"><?php echo $time->niceShort($log['Log']['created'], $offset); ?></td>
		<td><?php echo $log['Log']['username']; ?></td>
		<td class="log-text"><?php echo str_replace('<a', '<a rel="nofollow"', $text->autoLinkUrls(htmlentities($log['Log']['text']))); ?></td>
		<td class="actions">
			<?php echo $html->link(__('Report', true), array('action'=>'report', $log['Log']['id']), null, sprintf(__('Are you sure you want to report this message?', true))); ?>
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