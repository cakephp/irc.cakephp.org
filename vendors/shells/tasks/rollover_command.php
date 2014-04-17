<?php
/**
 * Sample CommandTask for CakeBot.v1.0 This is the ~rollover command
 *
 *
 * @package       cakebot
 * @subpackage    cakebot.vendors.shells.tasks
 */
class RolloverCommandTask extends Object {

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

	function execute($userName) {
		return "/me plays dead";
	}

}
