<?php 
/* SVN FILE: $Id$ */
/* Cakebot schema generated on: 2008-06-08 07:06:55 : 1212933535*/
class CakebotSchema extends CakeSchema {
	var $name = 'Cakebot';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $channels = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'enabled' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
			'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
			'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $logs = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'channel' => array('type'=>'string', 'null' => false, 'default' => NULL),
			'username' => array('type'=>'string', 'null' => false, 'default' => NULL),
			'text' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 2000),
			'created' => array('type'=>'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $tells = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'keyword' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 1000),
			'message' => array('type'=>'text', 'null' => false, 'default' => NULL),
			'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
}
?>