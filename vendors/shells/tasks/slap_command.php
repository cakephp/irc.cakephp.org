<?php
/**
 * Sample CommandTask for CakeBot.v1.0 This is the ~slap command
 *
 *
 * @package       cakebot
 * @subpackage    cakebot.vendors.shells.tasks
 */
class SlapCommandTask extends Object {

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

	function execute($userName, $otherUser) {
		if (empty($otherUser)) {
			return "/me slaps $userName for being a dumbass (Copyrighted by ADmad)";
		}
		return "/me slaps $otherUser with a large trout";
	}

}
