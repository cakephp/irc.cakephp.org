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
 * Tells controller
 *
 *
 * @package		cakebot
 * @subpackage	cakebot.controllers
 */
class TellsController extends AppController {

	var $name = 'Tells';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Tell->recursive = 0;
		$this->set('tells', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Tell.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tell', $this->Tell->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Tell->create();
			if ($this->Tell->save($this->data)) {
				$this->Session->setFlash(__('The Tell has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tell could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Tell', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Tell->save($this->data)) {
				$this->Session->setFlash(__('The Tell has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tell could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tell->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Tell', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tell->del($id)) {
			$this->Session->setFlash(__('Tell deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>