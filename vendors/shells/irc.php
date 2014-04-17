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
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakebot
 * @package       cakebot
 * @subpackage    cakebot.vendors
 * @since         CakeBot v (1.0)
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 * Commands:
 * ngircd : starts irc server
 * cake irc : launches irc bot
 *
 * @package       cakebot
 * @subpackage    cakebot.vendors
 */
class IrcShell extends Shell {
	var $tasks = array(
		'Bot',
		'BinCommand',
		'PhpCommand',
		'ApiCommand',
		'ApilookupCommand',
		'GoogleCommand',
		'IssuesCommand',
		'BookCommand',
		'RolloverCommand',
		'SlapCommand',
	);
/**
 * Not implemented
 *
 * @return void
 * @access public
 */
	function initialize() {}
/**
 * Not implemented
 *
 * @return void
 * @access public
 */
	function startup() {}
/**
 * Function that is called by
 *
 * @return void
 * @access public
 */
	function main() {
		foreach($this->tasks as $task) {
			if (substr($task, -7) == "Command") {
				$this->Bot->hooks[strtolower(substr($task, 0, -7))] = array($this->{$task}, 'execute');
			}
		}
		if (isset($this->args[0])) {
			$this->Bot->nick = $this->args[0];
		} else {
			$this->Bot->nick = 'CakeBot';
		}
		// It might be fun to say something every now and again like say, SVN commits
		//$this->Bot->setCallback();
		$this->Bot->execute();
	}
}
?>
