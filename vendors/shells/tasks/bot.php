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
/**
 * Nick to use in the channels
 *
 * @var string
 * @access public
 */
	var $nick = 'CakeBot';
	
/**
 * Internal channel holder
 *
 * @var string
 * @access public
 */
	var $channel = null;

/**
 * Internal requester holder
 *
 * @var string
 * @access public
 */
	var $requester = null;

/**
 * Channels to join once connected
 *
 * @var array
 * @access public
 */
	var $channels = array(
		'#cakephp',
	);

/**
 * Default connection paramiters 
 *
 * @var string
 * @access public
 */
	var $config = array(
		'host' => 'irc.freenode.net',
		'protocol' => 'irc',
		'port' => 6667,
		'persistent' => false
	);

/**
 * The call back function to be called every time there is a pong (status updates maybe?) (NOT YET IMPLEMENTED)
 *
 * @var string
 * @access public
 */
	var $callback = null;

/**
 * Associative array listing all the callback functions (using call_user_func) with their key as the function's name
 *
 * @var array
 * @access public
 */
	var $hooks = array(); // Fill with associative array

/**
 * Construct this object
 *
 * @return void
 * @access public
 */
	function __construct(&$dispatcher) {
		parent::__construct($this->config);
		$this->Dispatch =& $dispatcher;
	}

/**
 * Not implemented
 *
 * @return void
 * @access public
 */
	function startup() {}

/**
 * Not implemented
 *
 * @return void
 * @access public
 */
	function initialize() {}


/**
 * Not implemented
 *
 * @return void
 * @access public
 */
	function loadTasks() {}

/**
 * Overloads CakeSocket's connect
 *
 * @return boolean result
 * @access public
 */
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

/**
 * Join the requested channels
 *
 * @param string $nick the nickname to join as
 * @param mixed channels to join 
 * @return boolean on result of the join
 * @access public
 */
	function join($nick = null, $channels = array()) {
		$this->write("NICK " . $this->nick . "\r\n");
		$this->write("USER " . $this->nick . " " . $this->config['host'] . " botts :" . $this->nick . "\r\n");
		echo "USER " . $this->nick . " " . $this->config['host'] . " botts :" . $this->nick . "\r\n";
		foreach ($this->channels as $channel) {
			$this->write("JOIN " . $channel . "\r\n");
		}
		return true;
	}

/**
 * Deals with the input from the user
 *
 * @return void
 * @access public
 */
	function execute() {

		$channel = ClassRegistry::init('Channel');
		$channels = $channel->findAll("`enabled` = '1'");
		$this->channels = Set::extract($channels, "{n}.Channel.name");
		unset($channel, $channels);

		if ($this->connect()) {
			while (!feof($this->connection)) {

		        $line =  fgets($this->connection, 1024);

				if (stripos($line, 'PING') !== false) {
					list($ping, $pong) = $this->getParams(':', $line, 2);
					//$this->out($ping);
					if (isset($pong)) {
						//$this->out('PONG');
						$this->write("PONG $pong\r\n");

						/*
						if ($messages = call_user_func($this->callback)) {
							pr($messages);
							pr($this->channels);
							foreach ($messages as $message) {
								foreach ($this->channels as $channel) {
									$this->out("\n\nChannel: '$this->channel'\n\n");
									$this->write("PRIVMSG {$channel} :{$message}\r\n");
									$this->out("PRIVMSG {$channel} :{$message}");
								}
							}
						}
						*/
				        }
					unset($ping, $pong); //Php is bad about unsetting things since it's usual scope is one execution and this will help keep the program from filling up the computer
				} elseif ($line{0} === ':') {
					$params = $this->getParams("\s:", $line, 5);

					if (isset($params[2])) {

						$cmd = $params[2];
						$msg = $params[4];
						
						switch ($cmd) {
							case 'PRIVMSG':
								$this->channel = $params[3];
								$user = $this->getParams("!", $params[1], 3);
								$this->requester = $user[0];
								$this->out($msg);
								if($msg = $this->handleMessage($msg)) {
									$this->write("PRIVMSG {$this->channel} :{$msg}\r\n");
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
							case 'PART':

								$user = ClassRegistry::init('User');
								$thisUser = $user->findByUsername(substr($params[1], 0, strpos($params[1], "!")));
								$user->save(array(
									'User' => array(
										'id' => $thisUser['User']['id'],
										'username' => substr($params[1], 0, strpos($params[1], "!")),
										'date' => date('Y-m-d H:i:s')
									)
								));
								unset($user, $thisUser);
							break;
							default:
								$this->out($msg);
							break;
						}
						unset($cmd, $msg);
					}
				} else {
					if (trim($line) != "") {
						$this->out($line);
					}
					/*
					while($cmd = $this->in('enter an irc command')) {
						// /$this->write($cmd);
					}
					*/
				}
				unset($line, $params);
			}
		}
		return false;
	}

/**
 * Deals with the input from the user
 *
 * @param string $msg The inbound message
 * @return Return the message to send to the user/channel
 * @access public
 */
	function handleMessage($msg) {
		if (empty($msg)) {
			return $msg;
		}

		//Handle commands
		if ($msg{0} === '~') {
			$params = explode(" ", substr($msg, 1));
			switch ($params[0]) {
				case 'seen':
					$user = ClassRegistry::init('User');
					$user = $user->findByUsername($params[1], 'date', 'date desc');
					if (is_array($user) && count($user)) {
						return "{$this->requester}: I last saw {$params[1]} at {$user['User']['date']}";
					}
				break;
				case 'help':
					if (empty($params[2])) {
						$this->write("PRIVMSG {$this->requester} :!help all : to see all the tells.\r\n");
						$this->write("PRIVMSG {$this->requester} :!help <tell> to test one.\r\n");
						$this->write("PRIVMSG {$this->requester} :!help <number> to limit the number of commands.\r\n");
					} else {
						$tell = $params[1];
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
				case 'forget':
					$Tell = ClassRegistry::init('Tell');
					if ($Tell->delete($Tell->field('id', array('keyword' => $params[1])))){
						unset($Tell);
						return "It's almost like I didn't know a thing about {$params[1]}";
					}
					else {
						unset($Tell);
						$this->out("There was an error deleting the tell");
						return "There was an error deleting the tell";
					}
				break;
				default:
					//Check for a plugin before querying the DB
					$preAppend = "";
					if (strtolower(@$params[2]) == "about") { // Squelch since param 2 may not exist and this is faster
						$user = $params[1];
						$tell = $params[3];
						$preAppend = "$user: ";
					}
					else {
						$user = $this->requester;
						$tell = $params[0];
					}
					if (isSet($this->hooks[$tell])) {
						return $preAppend.call_user_func($this->hooks[$tell], $user);
					}
					
					$Tell = ClassRegistry::init('Tell');
					$message = $Tell->field('message', array('keyword' => $tell));
					unset($Tell);
					if($message) {
						return "{$user}: {$tell} is {$message}";
					}
					else {
						return "{$user}: I don't know enough about {$tell}";
					}
				break;
			}
		}
		elseif (substr($msg, 0, strlen($this->nick)) == $this->nick) {
			if (strpos($msg, " is")  == strpos($msg, " ", strlen($this->nick) + 2)) {
				$tell = substr($msg, strpos($msg, " ") + 1, strpos($msg, " is ") - strpos($msg, " ") - 1);
				$message = substr($msg, strpos($msg, " is ") + 4);
				//die("msg $msg\n$message");
				$Tell = ClassRegistry::init('Tell');
				if (!$Tell->findByKeyword($tell)) {
					$Tell->create();
					$Tell->save(array( 'Tell' => array(
						'keyword' => $tell,
						'message' => $message
					)));
					
					unset($tell, $Tell, $message, $msg);
					
					return "$this->requester, that's good to know";
				}
				else {
					return "$this->requester, I already have a definition for $tell";
				}
			}
		}

		//Log Messages
		$Log = ClassRegistry::init('Log');
		$Log->create(array('channel' => $this->channel, 'username' => $this->requester, 'text' => $msg));
		if ($Log->save()) {
			$this->out('message logged for ' . $this->requester . ' in ' . $this->channel);
		}

		unset($Log, $msg);
	}

/**
 * Does a regex match to handle the message
 *
 * @param mixed $regex expression to use
 * @param string $string to search on
 * @param integer $offset Offset for the regexp
 * @return Either the default value, or the user-provided input.
 * @access public
 */
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
