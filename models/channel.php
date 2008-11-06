<?php
/* SVN FILE: $Id$ */
/**
 * Short description for channel.php
 *
 * Long description for channel.php
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
 * @subpackage    cakebot.models
 * @since         1.0
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Channel class
 *
 * @package       cakebot
 * @subpackage    cakebot.models
 */
class Channel extends AppModel {
/**
 * name property
 *
 * @var string 'Channel'
 * @access public
 */
	var $name = 'Channel';
/**
 * validate property
 *
 * @var array
 * @access public
 */
	var $validate = array(
		'name' => array(
			'rule' => array('custom', '/#[a-z0-9\-]{1,}$/i'),
			'message' => 'Starting with # with more than one character or number'
		)
	);

}
?>