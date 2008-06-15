<h2 id="channels">Channels</h2>
	<p>
		CakeBot is currently running in <?php echo count($channels); ?> channels, to view the channel click one of the following links.
	</p>
	<br />
	<ul>
<?php
foreach ($channels as $channel) {
	//pr($channel);
	echo "\t\t<li>".$html->link($channel['Channel']['name'], array('controller' => 'logs', 'action' => 'view', substr($channel['Channel']['name'], 1)))."</li>";
}
?>
	</ul>