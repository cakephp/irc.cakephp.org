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
 * @copyright		Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link			http://www.cakefoundation.org/projects/info/cakebot
 * @package			$TM_DIRECTORY
 * @subpackage		$TM_DIRECTORY
 * @since			$TM_DIRECTORY v (1.0)
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Logs controller
 *
 *
 * @package		cakebot
 * @subpackage	cakebot.controllers
 */
class LogsController extends AppController {

	var $name = 'Logs';
	var $helpers = array('Html', 'Form', 'Time');
	var $uses = array('Log', 'Channel');

	var $paginate = array(
		'limit' => 100,
		'order' => array(
			'Log.created' => 'DESC'
		)
	);

	function index() {
		$this->Channel->recursive = 0;
		$this->set('channels', $this->Channel->find('all'));
	}

	function view($channel = null) {
		$this->Log->recursive = 0;
		$this->set('logs', $this->paginate('Log', array('channel' => "#$channel")));
	}

/*
	// at some point we may want an administrative delete feature for when people accidentaly put things up that they really don't want
	// Something like a "report this post" which makes it disapear then an administrative decision is made later
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Log', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Log->del($id)) {
			$this->Session->setFlash(__('Log deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
*/
}
?>