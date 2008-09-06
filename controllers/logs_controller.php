<?php
/* SVN FILE: $Id$ */
/**
 * Short description for logs_controller.php
 *
 * Long description for logs_controller.php
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework <http://www.cakephp.org/>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright            CakePHP(tm) : Rapid Development Framework <http://www.cakephp.org/>
 * @link                 http://www.cakephp.org
 * @package              cakebot
 * @subpackage           cakebot.controllers
 * @since                1.0
 * @version              $Revision$
 * @modifiedBy           $LastChangedBy$
 * @lastModified         $Date$
 * @license              http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * LogsController class
 *
 * @uses                 AppController
 * @package              cakebot
 * @subpackage           cakebot.controllers
 */
class LogsController extends AppController {
/**
 * name property
 *
 * @var string 'Logs'
 * @access public
 */
	var $name = 'Logs';
/**
 * helpers property
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html', 'Form', 'Time');
/**
 * uses property
 *
 * @var array
 * @access public
 */
	var $uses = array('Log', 'Channel');
/**
 * paginate property
 *
 * @var array
 * @access public
 */
	var $paginate = array(
		'limit' => 100,
		'order' => array(
			'Log.created' => 'DESC'
		)
	);
/**
 * index method
 *
 * @return void
 * @access public
 */
	function index() {
		$this->Channel->recursive = 0;
		$this->set('channels', $this->Channel->find('all'));
	}
/**
 * search method
 *
 * @param mixed $channel
 * @param mixed $term
 * @return void
 * @access public
 */
	function search($channel = null, $term = null) {
		if ($this->data) {
			$this->redirect(array($this->data['Search']['channel'], urlencode($this->data['Search']['query'])));
		}
		$this->Session->setFlash('Matching "' . htmlspecialchars($term) . '"');
		$this->Log->recursive = 0;
		if (strpos($term, '%') === false) {
			$term = '%' . $term . '%';
		}
		$conditions = array('channel' => "#$channel");
		$conditions['OR'] = array(
			'username LIKE ' => $term,
			'text LIKE ' => $term,
		);
		$this->set('logs', $this->paginate('Log', $conditions));
		$this->render('view');
	}
/**
 * view method
 *
 * @param mixed $channel
 * @return void
 * @access public
 */
	function view($channel = null) {
		$this->Log->recursive = 0;
		$this->set('logs', $this->paginate('Log', array('channel' => "#$channel")));
	}
/**
 * delete method
 *
 * at some point we may want an administrative delete feature for when people accidentaly put things up that they really don't want
 * Something like a "report this post" which makes it disapear then an administrative decision is made later
 *
 * @param mixed $id
 * @return void
 * @access public
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