<?php
/* SVN FILE: $Id$ */
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
 * @version			$Revision$
 * @modifiedby		$LastChangedBy$
 * @lastmodified	$Date$
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * Short description for class.
 *
 *
 * @package		cakebot
 * @subpackage	cakebot.vendors.shells.tasks
 */
App::import('Core', 'Socket');

class BotTask extends CakeSocket {

	var $nick = 'GwooBot';

	var $channels = array(
						'#test',
						);

	var $config = array('host' => '127.0.0.1', 'protocol' => 'irc', 'port' => 6667, 'persistent' => false);

	//var $callbacks = array('~' => 'tell', '!' => 'command');

	function __construct(&$dispatcher) {
		parent::__construct($this->config);
		$this->Dispatch =& $dispatcher;
	}

	function startup() {}

	function connect() {
		if (is_resource($this->connection)) {
			return true;
		}
		if (parent::connect()) {
			if ($this->join()) {
				return true;
			}
		} else {
			$this->out($this->lastError());
			$this->err('Could not connect');
		}
		return false;
	}

	function join($nick = null, $channels = array()) {
		$this->write("NICK " . $this->nick . "\r\n");
		$this->write("USER " . $this->nick . " " . $this->config['host'] . " botts :" . $this->nick . "\r\n");
		foreach ($this->channels as $channel) {
			$this->write("JOIN " . $channel . "\r\n");
		}
		return true;
	}

	function execute() {
		if ($this->connect()) {
			while (!feof($this->connection)) {

		        $line =  fgets($this->connection, 128);

				if (stripos($line, 'PING') !== false) {
					list($ping, $pong) = $this->getParams(':', $line, 2);
			        $this->out($ping);
			        if (isset($pong)) {
						$this->out('PONG');
			            $this->write("PONG " . $pong);
			        }
				} elseif ($line{0} === ':') {
					$params = $this->getParams("\s:", $line, 5);

					if (isset($params[2])) {

						$cmd = $params[2];
						$channel = $params[3];
						$msg = $params[4];

						switch ($cmd) {
							case 'PRIVMSG':
								$user = $this->getParams("!", $params[1], 3);
								$this->requester = $user[0];
								$this->out($msg);
								if($msg = $this->handleMessage($msg)) {
									$this->write("PRIVMSG {$channel} :{$msg}\r\n");
								}
							break;
							case '433': //Nick already registerd
								$this->out($msg);
								$this->nick = $this->nick . '_';
								$this->join();
							break;

							case '353':
								$this->out('Names on ' . str_replace('=', '', $msg));
							break;

							default:
								$this->out($msg);
							break;
						}
					}
				} else {
					$this->out($line);
					/*
					while($cmd = $this->in('enter an irc command')) {
						// /$this->write($cmd);
					}
					*/
				}
			}
		}
		return false;
	}

	function handleMessage($msg) {
		if (empty($msg)) {
			return $msg;
		}
		$Tell = ClassRegistry::init('Tell');
		$Log = ClassRegistry::init('Log');

		//Handle tells
		if ($msg{0} === '~') {
			if (stripos($msg, '~tell') !== false) {
				$params = $this->getParams("\s", $msg, 4);
				$user = $params[1];
				$tell = $params[3];
			} else {
				$params = $this->getParams("~", $msg, 2);
				$user = $this->requester;
				$tell = $params[1];
			}

			$message = $Tell->field('message', array('keyword' => $tell));
			$msg = "{$user}: {$tell} is {$message}";
			return $msg;
		}

		//Handle commands
		if ($msg{0} === '!') {
			$params = $this->getParams("\s!", $msg, 3);
			switch ($params[1]) {
				case 'seen':
					return $this->requester . ': You think I have seen someone?';
				break;
				case 'help':
					if (empty($params[2])) {
						$this->write("PRIVMSG {$this->requester} :!help all : to see all the tells.\r\n");
						$this->write("PRIVMSG {$this->requester} :!help <tell> to test one.\r\n");
						$this->write("PRIVMSG {$this->requester} :!help <number> to limit the number of commands.\r\n");
					} else {
						$tell = $params[2];
						if ($tell === 'all' || is_numeric($tell)) {
							$limit = 50;
							if (is_numeric($tell)) {
								$limit = $tell;
							}
							$tells = $Tell->find('list', array('fields' => array('Tell.keyword', 'Tell.message'), 'limit' => $limit));
							$this->write("PRIVMSG {$this->requester} :The following commands are available:\r\n");
							$this->write("PRIVMSG {$this->requester} :!help <command> to test it.\r\n");
							foreach ((array)$tells as $tell => $message) {
								$this->write("PRIVMSG {$this->requester} :{$tell}\r\n");
							}
						} else{
							$message = $Tell->field('message', array('keyword' => $tell));
							$this->write("PRIVMSG {$this->requester} :{$tell} is {$message}\r\n");
						}
					}
					return false;
				break;
			}
		}

		//Add Tell to database
		if (stripos($msg, $this->nick) !== false) {
			$params = $this->getParams("\s", $msg, 4);
			if (isset($params[2]) && $params[2] === 'is') {
				$tell = $params[1];
				$msg = $this->requester . ": I dont know about {$tell}";
				$message = $Tell->field('message', array('keyword' => $tell));
				if ($message) {
					$msg = $this->requester . ": I thought {$tell} was {$message}";
				} else {
					$message = $params[3];
					if ($Tell->save(array('keyword' => $tell, 'message' => $message))) {
						$msg = $this->requester . ": Cool, I will remember {$tell}";
					}
				}
			}
			return $msg;
		}
	}

	function getParams($regex, $string, $offset = -1) {
		return str_replace(array("\r\n", "\n"), '', preg_split("/[{$regex}]+/", $string, $offset));
	}

/**
 * Prompts the user for input, and returns it.
 *
 * @param string $prompt Prompt text.
 * @param mixed $options Array or string of options.
 * @param string $default Default input value.
 * @return Either the default value, or the user-provided input.
 * @access public
 */
	function in($prompt, $options = null, $default = null) {
		$in = $this->Dispatch->getInput($prompt, $options, $default);
		if ($options && is_string($options)) {
			if (strpos($options, ',')) {
				$options = explode(',', $options);
			} elseif (strpos($options, '/')) {
				$options = explode('/', $options);
			} else {
				$options = array($options);
			}
		}
		if (is_array($options)) {
			while ($in == '' || ($in && (!in_array(low($in), $options) && !in_array(up($in), $options)) && !in_array($in, $options))) {
				 $in = $this->Dispatch->getInput($prompt, $options, $default);
			}
		}
		if ($in) {
			return $in;
		}
	}
/**
 * Outputs to the stdout filehandle.
 *
 * @param string $string String to output.
 * @param boolean $newline If true, the outputs gets an added newline.
 * @access public
 */
	function out($string, $newline = true) {
		if (Configure::read() == 0) {
			return;
		}
		if (is_array($string)) {
			$str = '';
			foreach($string as $message) {
				$str .= $message ."\n";
			}
			$string = $str;
		}
		return $this->Dispatch->stdout($string, $newline);
	}
/**
 * Outputs to the stderr filehandle.
 *
 * @param string $string Error text to output.
 * @access public
 */
	function err($string) {
		if (Configure::read() == 0) {
			$this->log($err);
			return;
		}
		if (is_array($string)) {
			$str = '';
			foreach($string as $message) {
				$str .= $message ."\n";
			}
			$string = $str;
		}
		return $this->Dispatch->stderr($string."\n");
	}

}
?>