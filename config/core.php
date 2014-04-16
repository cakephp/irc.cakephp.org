<?php
/* SVN FILE: $Id$ */
/**
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 * 	3: As in 2, but also with full controller dump.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
	Configure::write('debug', 0);
/**
 * Application wide charset encoding
 */
	Configure::write('App.encoding', 'UTF-8');
/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below:
 */
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));
/**
 * Uncomment the define below to use CakePHP admin routes.
 *
 * The value of the define determines the name of the route
 * and its associated controller actions:
 *
 * 'admin' 		-> admin_index() and /admin/controller/index
 * 'superuser' -> superuser_index() and /superuser/controller/index
 */
	//Configure::write('Routing.admin', 'admin');

/**
 * Turn off all caching application-wide.
 *
 */
	//Configure::write('Cache.disable', true);
/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * var $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting var $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
	//Configure::write('Cache.check', true);
/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
	define('LOG_ERROR', 2);
/**
 * The preferred session handling method. Valid values:
 *
 * 'php'	 		Uses settings defined in your php.ini.
 * 'cake'		Saves session files in CakePHP's /tmp directory.
 * 'database'	Uses CakePHP's database sessions.
 *
 * To define a custom session handler, save it at /app/config/<name>.php.
 * Set the value of 'Session.save' to <name> to utilize it in CakePHP.
 *
 * To use database sessions, execute the SQL file found at /app/config/sql/sessions.sql.
 *
 */
	Configure::write('Session.save', 'php');
/**
 * The name of the table used to store CakePHP database sessions.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 *
 * The table name set here should *not* include any table prefix defined elsewhere.
 */
	//Configure::write('Session.table', 'cake_sessions');
/**
 * The DATABASE_CONFIG::$var to use for database session handling.
 *
 * 'Session.save' must be set to 'database' in order to utilize this constant.
 */
	//Configure::write('Session.database', 'default');
/**
 * The name of CakePHP's session cookie.
 */
	Configure::write('Session.cookie', 'CAKEPHP');
/**
 * Session time out time (in seconds).
 * Actual value depends on 'Security.level' setting.
 */
	Configure::write('Session.timeout', '120');
/**
 * If set to false, sessions are not automatically started.
 */
	Configure::write('Session.start', true);
/**
 * When set to false, HTTP_USER_AGENT will not be checked
 * in the session
 */
	Configure::write('Session.checkAgent', true);
/**
 * The level of CakePHP security. The session timeout time defined
 * in 'Session.timeout' is multiplied according to the settings here.
 * Valid values:
 *
 * 'high'	Session timeout in 'Session.timeout' x 10
 * 'medium'	Session timeout in 'Session.timeout' x 100
 * 'low'		Session timeout in 'Session.timeout' x 300
 *
 * CakePHP session IDs are also regenerated between requests if
 * 'Security.level' is set to 'high'.
 */
	Configure::write('Security.level', 'high');
/**
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', '66a61381cf823d447d29d0881f27f3b2ae608f17');
/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');
/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');
/**
 * The classname and database used in CakePHP's
 * access control lists.
 */
	Configure::write('Acl.classname', 'DB_ACL');
	Configure::write('Acl.database', 'default');
/**
 * Cache Engine Configuration
 *
 * File storage engine.
 * default dir is /app/tmp/cache/
 * 	 Cache::config('default', array('engine' => 'File' //[required]
 *									'duration'=> 3600, //[optional]
 *									'probability'=> 100, //[optional]
 * 		 							'path' => '/tmp', //[optional] use system tmp directory - remember to use absolute path
 * 									'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 * 									'lock' => false, //[optional]  use file locking
 * 									'serialize' => true, [optional]
 *								)
 * 					);
 *
 * APC (Alternative PHP Cache)
 * 	 Cache::config('default', array('engine' => 'Apc' //[required]
 *									'duration'=> 3600, //[optional]
 *									'probability'=> 100, //[optional]
 *								)
 * 					);
 *
 * Xcache (PHP opcode cacher)
 * 	 Cache::config('default', array('engine' => 'Xcache' //[required]
 *									'duration'=> 3600, //[optional]
 *									'probability'=> 100, //[optional]
 *									'user' => 'admin', //user from xcache.admin.user settings
 *      							password' => 'your_password', //plaintext password (xcache.admin.pass)
 *								)
 * 					);
 *
 * Memcache
 * 	 Cache::config('default', array('engine' => 'Memcache' //[required]
 *									'duration'=> 3600, //[optional]
 *									'probability'=> 100, //[optional]
 * 									'servers' => array(
 * 												'127.0.0.1', // localhost, default port
 * 												'10.0.0.1:12345', // port 12345
 * 											), //[optional]
 * 									'compress' => true, // [optional] compress data in Memcache (slower, but uses less memory)
 *								)
 * 					);
 *
 * Cake Model
 * 	 Cache::config('default', array('engine' => 'Model' //[required]
 *									'duration'=> 3600, //[optional]
 *									'probability'=> 100, //[optional]
 * 									'className' => 'Cache', //[optional]
 * 									'fields' => array('data' => 'data', 'expires' => 'expires'), //[optional]
 * 									'serialize' => true, [optional]
 *								)
 * 					);
 */
	Cache::config('default', array('engine' => 'File'));
?>
