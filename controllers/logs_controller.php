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
 * LogsController class
 *
 * @package       cakebot
 * @subpackage    cakebot.controllers
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
	var $helpers = array('Html', 'Form', 'Time', 'Text');
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
	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('link'));
	}

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
		if (!empty($this->params['named']['page']) && $this->params['named']['page'] > 50) {
			$this->redirect('/');
		}
		$this->set('logs', $this->paginate('Log', array('channel' => "#$channel")));
	}

/**
 * link method
 *
 * 'perma' link to an individual message
 *
 * @param mixed $id
 * @return void
 * @access public
 */
	function link($id = null, $_wrap = null) {
		$wrap = $_wrap;
		if (!$wrap) {
			$wrap = 20;
		}
		if ($wrap > 50) {
			$this->redirect('/');
		}
		if (!$id) {
			$this->redirect($this->referer('/', true));
		}
		$channel = $this->Log->field('channel', array('id' => $id));
		$first = $this->Log->find('first', array(
			'fields' => array('id'),
			'conditions' => array ('channel' => $channel, 'id >=' => $id),
			'offset' => $wrap,
			'limit' => 1,
			'order' => 'id ASC'
		));
		if (!$first) {
			$first = $this->Log->find('first', array(
				'fields' => array('id'),
				'conditions' => array ('channel' => $channel, 'id >=' => $id),
				'order' => 'id DESC'
			));
		}
		$last = $this->Log->find('first', array(
			'fields' => array('id'),
			'conditions' => array ('channel' => $channel, 'id <=' => $id),
			'offset' => $wrap,
			'limit' => 1,
			'order' => 'id DESC'
		));
		if (!$last) {
			$last = $this->Log->find('first', array(
				'fields' => array('id'),
				'conditions' => array ('channel' => $channel, 'id <=' => $id),
				'order' => 'id ASC'
			));
		}

		$this->paginate['limit'] = $wrap * 3;
		$this->set('logs', $this->paginate('Log', array(
			'channel' => $channel,
			'id <=' => $first['Log']['id'],
			'id >=' => $last['Log']['id'],
		)));
		$this->set('highlight', $id);
		$this->set('wrap', $_wrap);
		$this->render('view');
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
