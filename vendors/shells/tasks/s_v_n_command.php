<?php
/* SVN FILE: $Id: $ */
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
 * @version			$Revision: 21 $
 * @modifiedby		$LastChangedBy: gwoo $
 * @lastmodified	$Date: 2008-05-27 12:58:52 -0700 (Tue, 27 May 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * CakeBot plugin so that you can call ~svn and get the latest svn revision's number and message
 *
 *
 * @package		cakebot
 * @subpackage	cakebot.vendors.shells.tasks
 */
App::import('Core', 'HttpSocket');
App::import('Core', 'xml');
class SVNCommandTask extends Object {
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
 * Function called by Bot to get the listing from the svn server
 *
 * @return string message for the user/channel
 * @access public
 */
	function execute() {
		if (function_exists("svn_log")) {
			if (func_num_args() > 1) {
				$args = func_get_args();
				$log = $this->svn_log_limit ( "https://svn.cakephp.org/repo/branches/1.2.x.x/", $args[1] );
				if ($log) {
					$lastRevision = $log[0]['rev'];
					return "Revision {$log[0]['rev']} ({$log[0]['author']}): {$log[0]['msg']}";
				} else {
					return "Revision $args[1] is not a valid revision";
				}
			} else {
				$log = $this->svn_log_limit ( "https://svn.cakephp.org/repo/branches/1.2.x.x/" );
				$lastRevision = $log[0]['rev'];
				return "Revision {$log[0]['rev']} ({$log[0]['author']}): {$log[0]['msg']}";
			}
		} else {
			return "svn is https://svn.cakephp.org/repo/";
		}
	}
/**
 * Ripped from http://php.oregonstate.edu/manual/en/function.svn-log.php get the limited log
 *
 * @param string SVN url to check
 * @return mixed array of svn_log variables
 * @access public
 */
	function svn_log_limit($repos_url, $rev = null) {
		$limit = 1;
		// -q flag used to prevent server from sending log messages
		$revision = ($rev == null ? "" : "-r $rev");
		$output = shell_exec("svn log -q {$revision} --limit $limit $repos_url");
		preg_match_all('/^r(\d+) /m', $output, $matches);
		$ret = array();
		foreach ($matches[1] as $rev) {
			$log = svn_log($repos_url, (int) $rev);
			$ret[] = $log[0]; // log is only one item long
		}
		return $ret;
	}
}
?>