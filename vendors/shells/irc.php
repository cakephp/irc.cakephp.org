<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
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
 * @package			cakebot
 * @subpackage		cakebot.vendors
 * @since			CakeBot v (1.0)
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 * Commands:
 * ngircd : starts irc server
 * cake irc : launches irc bot
 *
 * @package		cakebot
 * @subpackage	cakebot.vendors
 */
class IrcShell extends Shell {

	var $tasks = array('Bot');

	function initialize() {}

	function startup() {}

	function main() {
		$this->Bot->execute();
	}
}