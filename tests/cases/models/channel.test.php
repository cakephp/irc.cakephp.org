<?php 
/* SVN FILE: $Id$ */
/* Channel Test cases generated on: 2008-06-05 19:06:26 : 1212715466*/
App::import('Model', 'Channel');

class TestChannel extends Channel {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class ChannelTestCase extends CakeTestCase {
	var $Channel = null;
	var $fixtures = array('app.channel');

	function start() {
		parent::start();
		$this->Channel = new TestChannel();
	}

	function testChannelInstance() {
		$this->assertTrue(is_a($this->Channel, 'Channel'));
	}

	function testChannelFind() {
		$results = $this->Channel->recursive = -1;
		$results = $this->Channel->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Channel' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2008-06-05 19:24:26',
			'modified'  => '2008-06-05 19:24:26'
			));
		$this->assertEqual($results, $expected);
	}
}
?>