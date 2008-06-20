<?php
/* SVN FILE: $Id: channels_controller.php 33 2008-06-15 02:18:15Z gwoo $ */
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
 * @version			$Revision: 33 $
 * @modifiedby		$LastChangedBy: gwoo $
 * @lastmodified	$Date: 2008-06-14 19:18:15 -0700 (Sat, 14 Jun 2008) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class Channel extends AppModel {

	var $name = 'Channel';
	var $validate = array(
		'name' => array(
			'rule' => array('custom', '/#[a-z0-9]{1,}$/i'),
			'message' => 'Starting with # with more than one character or number'
		)
	);

}
?>