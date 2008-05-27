<?php 
/* SVN FILE: $Id$ */
/* Cakebot10XX schema generated on: 2008-05-27 12:05:14 : 1211918114*/
class Cakebot10XXSchema extends CakeSchema {
	var $name = 'Cakebot10XX';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $logs = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'channel' => array('type'=>'string', 'null' => false, 'length' => 50),
			'username' => array('type'=>'string', 'null' => false, 'length' => 50),
			'text' => array('type'=>'text', 'null' => false),
			'indexes' => array('id' => array('column' => 'id', 'unique' => 1))
		);
	var $tells = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'keyword' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
			'message' => array('type'=>'text', 'null' => true, 'default' => NULL),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
}
?>