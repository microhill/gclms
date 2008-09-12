<?
/* SVN FILE: $Id: routes.php 4407 2007-02-02 10:39:45Z phpnut $ */
/**
 * Short description for file.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2007, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright 2005-2007, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package			cake
 * @subpackage		cake.app.config
 * @since			CakePHP(tm) v 0.2.9
 * @version			$Revision: 4407 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2007-02-02 03:39:45 -0700 (Fri, 02 Feb 2007) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */

$cake_admin = Configure::read('Routing.admin');

Router::connectNamed(array('group','course','file','class','user')); 

Router::parseExtensions('rss','json');

Router::connect('/selenium/results', array('controller' => 'selenium', 'action' => 'results'));
Router::connect('/selenium/*', array('controller' => 'selenium', 'action' => 'display'));

if (file_exists(CONFIGS.'installed.txt')) {
	Router::connect('/', array('controller' => 'student_center', 'action' => 'index'));

	Router::connect('/users/users/*',array('controller' => 'users','action' => 'logout'));

	Router::connect('/update/:action/*',
		array('controller'=>'Update'),
		array('action'=> 'index', 'controller' => 'update'));

	Router::connect('/administration',array($cake_admin => $cake_admin,'controller' => 'statistics','action' => 'index'));
	Router::connect('/administration/:controller/:action/*',array($cake_admin => $cake_admin));
	Router::connect('/administration/:controller/*',array($cake_admin => $cake_admin));
	Router::connect('/administration/*',array($cake_admin => $cake_admin,'controller'=>'panel'));

	Router::connect('/courses/:action/', array('controller' => 'courses'));
	Router::connect('/register/:action/*', array('controller' => 'register'));
	Router::connect('/profile/:action/*', array('controller' => 'profile'));
	
	//Router::connect('/question_responses/:action/*', array('controller' => 'question_responses'));
	
	Router::connect('/notebook/:action/*', array('controller' => 'notebook'));
	Router::connect('/user/:user', array('controller' => 'users','action' => 'view'),array('user' => $UUID));
	
	Router::connect('/groups/:action/*', array('controller' => 'groups'));
	
	//[0-9]+
	
	Router::connect('/users/:action/*', array('controller' => 'users'));
	
	//Configure::load('plugins');
	//$activatedPlugins = implode('|',array_keys(Configure::read('Plugins.activated')));
	//Router::connect('/:group/:course/:plugin/:action/*',array(),array('plugin'=>$activatedPlugins));
	
	Router::connect('/:group/', array('controller' => 'groups','action' => 'show'));

	Router::connect('/:group/(files|configuration|facilitators|classes|courses)/:action/*', array(), array('controller' => 'files|configuration|facilitators|classes|courses'));
	Router::connect('/:group/:course', array('controller' => 'courses','action' => 'show'));

	Router::connect('/:group/:course/configuration/delete',array('controller'=>'courses','action'=>'delete'));
	Router::connect('/:group/:course/configuration',array('controller'=>'courses','action'=>'edit'));

	Router::connect('/:group/:course/:class',array('controller' => 'announcements'),array('class' => $UUID));
	Router::connect('/:group/:course/:class/:controller/:action/*',array(),array('class' => $UUID));
	Router::connect('/:group/:course/:class/:controller/*',array(),array('class' => $UUID));
			
	Router::connect('/:group/:course/:controller');
	Router::connect('/:group/:course/files/:action',array('controller'=>'files'),array('action' => 'media|images|thumbnail|delete|create_thumbnail|migrate_to_s3'));
	
	Router::connect('/:group/:course/files/:file',array('controller'=>'files','action'=>'file'));

	Router::connect('/:group/:course/:controller/:action/*');
	
	Router::connect('/update/:action/*',
		array('controller'=>'Update'),
		array('action'=> 'index', 'controller' => 'update'));
} else {
	Router::connect('/', array('controller' => 'install', 'action' => 'index'));
	Router::connect('/pages/*', array('controller' => 'install', 'action' => 'index'));
}

Configure::write('Database.configuration_file_exists', file_exists(CONFIGS.'database.php') ? false : true);