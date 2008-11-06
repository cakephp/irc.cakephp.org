<?php
/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cakebot
 * @subpackage    cakebot
 * @since         cakebot v 1.0
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * AppController class
 *
 * @package       cakebot
 * @subpackage    cakebot
 */
class AppController extends Controller {
/**
 * components property
 *
 * @var array
 * @access public
 */
	var $components = array('Auth');
/**
 * beforeFilter method
 *
 * @return void
 * @access public
 */
	function beforeFilter() {
		$this->Auth->allow(array('index', 'view', 'display', 'search'));
	}
}
?>