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
 * Give links to the users for the CakePHP API
 *
 *
 * @package       cakebot
 * @subpackage    cakebot.vendors.shells.tasks
 */
class ApilookupCommandTask extends Object {
/**
 * Holds the available api tabs.
 *
 * @var array
 * @access public
 */
	var $apiTabs = array(
		'1.1' => '1.1/',
		'tests' => 'tests/',
	);
/**
 * Holds the current api tab
 *
 * @var string
 *
 * @access public
 */
	var $apiTab;
/**
 * Not implemented
 *
 * @return void
 * @access public
 */
	function startup() {}
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
	function loadTasks() {}
/**
 * Returns a URL to search the api. Allows for _ . and : in the query string.
 *
 * Examples:
 * ~apilookup (returns $nick: : What are you looking for?)
 * ~apilookup foo (returns $nick: http://api.cakephp.org/search.php?query=foo)
 * ~apilookup tests foo (returns $nick: http://api.cakephp.org/tests/search.php?query=foo)
 * ~apilookup 1.1 foo (returns $nick: http://api.cakephp.org/1.1/search.php?query=foo)
 *
 * @param string $userName the username to send this message to
 * @return string the message to send to the user/channel
 * @access public
 */
	function execute() {
		$apilookupURL = "%s: http://api.cakephp.org/search/%s";
		$queryString = '';
		$counter = 0;
		$args = func_get_args();
		foreach($args as $arg) {
			if($counter == 0) {
				$nick = $arg;
			}
			if($counter == 1) {
				$queryString .= $arg;
			} elseif($counter > 1) {
				$queryString .= "+" . $arg;
			}
			$counter++;
		}
		App::import('Sanitize');
		$queryString = str_replace(":", "+", $queryString);
		$queryString = Sanitize::paranoid($queryString, array('+', '_', '.'));
		if(count($args) > 1) {
			$return =  sprintf($apilookupURL, $nick, $queryString);
		} else {
			$return = $nick . ": What are you looking for? try ~apilookup model";
		}
		$apilookupURL = $queryString = $counter = $args = $arg = $nick = $this->apiTab = null;
		return $return;
	}
}
?>