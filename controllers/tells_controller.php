<?php
/* SVN FILE: $Id$ */
/**
 * Short description for tells_controller.php
 *
 * Long description for tells_controller.php
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework <http://www.cakephp.org/>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     CakePHP(tm) : Rapid Development Framework <http://www.cakephp.org/>
 * @link          http://www.cakephp.org
 * @package       cakebot
 * @subpackage    cakebot.controllers
 * @since         1.0
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * TellsController class
 *
 * @package       cakebot
 * @subpackage    cakebot.controllers
 */
class TellsController extends AppController {
/**
 * name property
 *
 * @var string 'Tells'
 * @access public
 */
	var $name = 'Tells';
/**
 * helpers property
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html', 'Form');
/**
 * index method
 *
 * @return void
 * @access public
 */
	function index() {
		$this->Tell->recursive = 0;
		$this->set('tells', $this->paginate());
	}
/**
 * view method
 *
 * @param mixed $id
 * @return void
 * @access public
 */
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Tell.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tell', $this->Tell->read(null, $id));
	}
/**
 * add method
 *
 * @return void
 * @access public
 */
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
/**
 * edit method
 *
 * @param mixed $id
 * @return void
 * @access public
 */
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
/**
 * delete method
 *
 * @param mixed $id
 * @return void
 * @access public
 */
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