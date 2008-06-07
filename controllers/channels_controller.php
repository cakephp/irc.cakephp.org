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
 * Channels controller
 *
 *
 * @package		cakebot
 * @subpackage	cakebot.controllers
 */class ChannelsController extends AppController {

	var $name = 'Channels';
	var $helpers = array('Html', 'Form');

/**
 * View channel listings
 *
 * @return void
 * @access public
 */
	function index() {
		$this->Channel->recursive = 0;
		$this->set('channels', $this->paginate());
	}

/**
 * View a single channel
 *
 * @return void
 * @access public
 */
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Channel.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('channel', $this->Channel->read(null, $id));
	}

/**
 * Add a new channel
 *
 * @return void
 * @access public
 */
	function add() {
		if (!empty($this->data)) {
			$this->Channel->create();
			if ($this->Channel->save($this->data)) {
				$this->Session->setFlash(__('The Channel has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Channel could not be saved. Please, try again.', true));
			}
		}
	}

/**
 * Edit an existing channel
 *
 * @return void
 * @access public
 */
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Channel', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Channel->save($this->data)) {
				$this->Session->setFlash(__('The Channel has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Channel could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Channel->read(null, $id);
		}
	}

/**
 * Delete a channel
 *
 * @return void
 * @access public
 */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Channel', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Channel->del($id)) {
			$this->Session->setFlash(__('Channel deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>