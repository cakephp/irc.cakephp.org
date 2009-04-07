<?php
class BookCommandTask extends Object {
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
 * Create the message
 *
 * @param string $userName the username to send this message to
 * @return string the message to send to the user/channel
 * @access public
 */
	function execute() {
		if (func_num_args() > 1) {
			$q = implode(array_splice(func_get_args(), 1), '+');
			$url =  sprintf( "http://book.cakephp.org/search/%s", $q);
			return $url;
		} else {
			return "Book is http://book.cakephp.org the answer to life, the universe and all your bun making needs.";
		}
	}
}