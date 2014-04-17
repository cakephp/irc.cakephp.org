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
 *                              1785 E. Sahara Avenue, Suite 490-204
 *                              Las Vegas, Nevada 89104
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

App::import('Core', 'HttpSocket'); // for version 1.3

/**
 * This is the ~issues command
 *
 *
 * @package       cakebot
 * @subpackage    cakebot.vendors.shells.tasks
 */
class IssuesCommandTask extends Object {
/**
 * Not implemented
 *
 * @return void
 * @access public
 */
    function startup() {
    }
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
    function execute($userName = null, $query = null) {
        $args = func_num_args();
        // when user types ~issues
        if ($args == 1) return 'Submit your issue here: http://github.com/cakephp/cakephp/issues';

        // when users type: ~issues searchkeys
        $searchString = urlencode(implode(array_splice(func_get_args(), 1), " "));
        $HttpSocket = new HttpSocket();
        $results = json_decode($HttpSocket->get("https://api.github.com/search/issues?sort=created&order=asc&q=repo:cakephp/cakephp+{$searchString}"), true);
        unset($HttpSocket);

        if (empty($results['items'])) {
            unset($results, $searchString);
            return "No issues found.";
        }

        $count = (int)$results['total_count'];
        if ($count > 1) {
            $out = sprintf("%d tickets found. To see the tickets go to: https://github.com/cakephp/cakephp/search?type=Issues&q=%s", $count, $searchString);
            unset($results, $count, $searchString);
            return $out;
        }

        $out = sprintf("1 ticket found. To see the ticket go to: %s", $results['items'][0]['url']);
        unset($results, $count, $searchString);
        return $out;
    }
}
