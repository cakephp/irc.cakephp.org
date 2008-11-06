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
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakebot
 * @package       cakebot
 * @subpackage    cakebot
 * @since         cakebot v (1.0)
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Core', 'Socket');
App::import('Core', 'Set');
/**
 * BotTask class
 *
 * @package       cakebot
 * @subpackage    cakebot.vendors.shells.tasks
 */
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
 * Contains the names of all active users inside of sub array's for each channel
 */
	var $activeUsers = array();
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
			if ($this->login() && $this->join()) {
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
	function login($nick = null, $password = null) {
		if ($password === null) {
			$nick = $this->nick;
		}
		$this->write("NICK {$nick}\r\n");
		$this->write("USER {$nick} {$this->config['host']} botts : {$nick}\r\n");
		return true;
	}
/**
 * Join the requested channels
 *
 * @param string $nick the nickname to join as
 * @param mixed channels to join
 * @return boolean on result of the join
 * @access public
 */
	function join($channels = array()) {
		if (!empty($channels)) {
			$channels = array_merge($this->channels, $channels);
		} else {
			$channels = $this->channels;
		}
		foreach ($channels as $channel => $password) {
			if (is_numeric($channel)) {
				$channel = $password;
				$password = null;
			}
			$this->write("JOIN {$channel} {$password}\r\n");
			$this->activeUsers[$channel] = array();
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
		//Pull up all the channels
		$channel = ClassRegistry::init('Channel');
		$channels = $channel->find('all', array('conditions' => array('Channel.enabled' => 1)));
		$this->channels = Set::extract($channels, "{n}.Channel.name");
		unset($channel, $channels);
		if ($this->connect()) {
			while (is_resource($this->connection) && !feof($this->connection)) {
				$line =  fgets($this->connection, 1024);
				if (stripos($line, 'PING') !== false) {
					list($ping, $pong) = $this->getParams(':', $line, 2);
					if (isset($pong)) {
						$this->write("PONG $pong\r\n");
						// Now that we have the pong, maybe put a callback function here ot maybe output regular messages
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
						$msg = @$params[4];
						switch ($cmd) {
						case 'PRIVMSG':
							$this->channel = $params[3];
							$user = $this->getParams("!", $params[1], 3);
							$this->requester = $user[0];
							if ($this->requester != "freenode-connect") {
								$this->out(date('H:i:s')." $this->requester: $msg");
								if($msg = $this->handleMessage($msg)) {
									if($this->channel == $this->nick){
										$this->channel = $this->requester;
									}
									$this->write("PRIVMSG {$this->channel} :{$msg}\r\n");
								}
							}
							break;
						case '433': //Nick already registerd
							$this->out($msg);
							$this->nick = $this->nick . '_';
							$this->join();
							break;
						case '353': //Names are sent on join this is they
							$channel = strstr($msg, "#");
							$channel = substr($channel, 0, strpos($channel, " "));
							$this->activeUsers["#$channel"] = explode(' ', trim(str_replace(array('=', '@', '~', '!', ':'), '', strstr($msg, ":"))));
							$this->out('Names on ' . $channel . ' added');
							break;
						case 'PART':
						case 'JOIN':
							$channel = $params[3];
							$user = ClassRegistry::init('User');
							$userName = substr($params[1], 0, strpos($params[1], "!"));
							if ($cmd == 'PART') {
								//Take them from the active listing
								for ($i = 0; $i < count($this->activeUsers["#$channel"]); $i++) {
									if ($this->activeUsers["#$channel"][$i] == $userName) {
										unset ($this->activeUsers["#$channel"][$i]);
									}
								}
							} else {
								//Add them to the active list
								$this->activeUsers["#$channel"][] = $userName;
							}
							$thisUser = $user->findByUsername($userName);
							if(empty($thisUser)) {
								$user->create();
							}
							$thisUser['User']['username'] = $userName;
							$thisUser['User']['date'] = date('Y-m-d H:i:s');
							if ($user->save($thisUser)) {
								$this->out("Saved {$userName}'s state change");
							}
							else {
								$this->out("Unable to save {$userName}'s state change");
							}
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
		if (!$this->log(array('channel' => $this->channel, 'username' => $this->requester, 'text' => $msg))) {
			$this->out('Error loggin message for ' . $this->requester . ' in ' . $this->channel);
		}
		//Handle commands
		if ($msg{0} === '~' || $msg{0} === '!') {
			//create an array of the paramiters from the call offset by the location of the first ~
			$params = explode(" ", substr($msg, strpos($msg, "~") + 1));
			switch ($params[0]) {
			case 'seen':
				//Searching for nothing
				if(empty($params[1])){
					return "{$this->requester}: Who are you seeking ?";
				}
				//Seen themselvs?
				if($params[1] == $this->requester){
					return "{$this->requester}: Hide and seek? Found you!";
				}
				//Searching for someone who is active
				if (in_array($params[1], $this->activeUsers["#$this->channel"])) {
					return "{$this->requester}: $params[1] is here right now!";
				}
				$user = ClassRegistry::init('User');
				$user = $user->findByUsername($params[1], 'date', 'date desc');
				App::import('Core', 'Helper');
				App::import('Helper', 'Time');
				$time = new TimeHelper();
				$user = ClassRegistry::init('User');
				$timeZoneOffset = date('P');
				$user = $user->findByUsername($params[1], 'date', 'date desc');
				if (is_array($user) && count($user)) {
					return "{$this->requester}: I last saw {$params[1]} {$time->timeAgoInWords($user['User']['date'])}";
				}
				else {
					return "{$this->requester}: I haven't seen {$params[1]} in a while";
				}
				break;
			case 'help':
				if (empty($params[1])) {
					$this->write("PRIVMSG {$this->requester} :~help all : to see all the tells.\r\n");
					$this->write("PRIVMSG {$this->requester} :~help <number> to limit the number of commands.\r\n");
				} else {
					if (isset($params[1])) {
						$input = $params[1];
						$Tell = ClassRegistry::init('Tell');
						if ($input === 'all' || is_numeric($input)) {
							$limit = 50;
							if (is_numeric($input)) {
								$limit = $input;
							}
							$tells = $Tell->find('list', array('fields' => array('Tell.keyword', 'Tell.message'), 'limit' => $limit));
							//pr($tells);
							$this->write("PRIVMSG {$this->requester} :The following commands are available:\r\n");
							$this->write("PRIVMSG {$this->requester} :~<tell> to test it.\r\n");
							$tells = array_flip($tells);
							$this->write("PRIVMSG {$this->requester} :forget, seen, ".implode($tells, ", ")."\r\n");
						} else {
							$message = $Tell->field('message', array('keyword' => $input));
							if(!empty($message)){
								$this->write("PRIVMSG {$this->requester} :{$input} is {$message}\r\n");
							} else {
								$this->write("PRIVMSG {$this->requester} :I don't know enough about {$input}\r\n");
							}
						}
					}
				}
				return false;
				break;
			case 'forget':
				$Tell = ClassRegistry::init('Tell');
				if ($Tell->delete($Tell->field('id', array('keyword' => $params[1])))) {
					unset($Tell);
					return "It's almost like I didn't know a thing about {$params[1]}";
				}
				else {
					unset($Tell);
					$this->out("There was an error deleting the tell");
					return "There was an error deleting the tell";
				}
				break;
				// There are no built in functions that they want, check the plugins and the tell database
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
					if ($preAppend) { //This is an about
						$extraParams = array_slice($params, 4);
					}
					else {
						$extraParams = array_slice($params, 1);
					}
					return $preAppend.call_user_func_array($this->hooks[$tell], am(array($user), $extraParams));
				}
				unset ($preAppend);
				$Tell = ClassRegistry::init('Tell');
				$message = $Tell->field('message', array('keyword' => $tell));
				unset($Tell);
				if ($message) {
					return "{$user}: {$tell} is {$message}";
				}
				else {
					return "{$user}: I don't know enough about {$tell}";
				}
				break;
			}
		}
		// Catch messages that have been directed to this bot's nick
		// This could be a definition
		elseif (strtolower(substr($msg, 0, strlen($this->nick))) == strtolower($this->nick)) {
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
		unset($msg);
	}
/**
 * log method
 *
 * @param array $input
 * @return void
 * @access public
 */
	function log($input = array()) {
		if (!isset($input['created'])) {
			$input['created'] = date('Y-m-d H:i:s');
		}
		$Log = ClassRegistry::init('Log');
		$Log->create($input);
		return $Log->save();
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