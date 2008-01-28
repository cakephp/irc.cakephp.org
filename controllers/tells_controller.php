<?php
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