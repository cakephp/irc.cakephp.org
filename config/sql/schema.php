<?php
/* SVN FILE: $Id$ */
/* Cakebot10XX schema generated on: 2008-06-20 09:06:20 : 1213977800*/
class AppSchema extends CakeSchema {
	var $name = 'Cakebot';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $channels = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'enabled' => array('type'=>'boolean', 'null' => false),
			'name' => array('type'=>'string', 'null' => false),
			'created' => array('type'=>'datetime', 'null' => false),
			'modified' => array('type'=>'datetime', 'null' => false),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $logs = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'channel' => array('type'=>'string', 'null' => false, 'length' => 200),
			'username' => array('type'=>'string', 'null' => false),
			'text' => array('type'=>'string', 'null' => false),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $tells = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'keyword' => array('type'=>'string', 'null' => false, 'length' => 1000),
			'message' => array('type'=>'text', 'null' => false),
			'created' => array('type'=>'datetime', 'null' => false),
			'modified' => array('type'=>'datetime', 'null' => false),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $users = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'username' => array('type'=>'string', 'null' => false),
			'date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
}
?>