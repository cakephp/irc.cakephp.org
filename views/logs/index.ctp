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