<?php
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