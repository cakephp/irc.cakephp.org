<?php 
/* SVN FILE: $Id$ */
/* Channel Fixture generated on: 2008-06-05 19:06:26 : 1212715466*/

class ChannelFixture extends CakeTestFixture {
	var $name = 'Channel';
	var $table = 'channels';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
			'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
			'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
			'indexes' => array()
			);
	var $records = array(array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2008-06-05 19:24:26',
			'modified'  => '2008-06-05 19:24:26'
			));
}
?>