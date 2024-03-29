<?php
/* SVN FILE: $Id: bootstrap.php 2951 2006-05-25 22:12:33Z phpnut $ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright (c)	2006, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		Copyright (c) 2006, Cake Software Foundation, Inc.
 * @link				http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package			cake
 * @subpackage		cake.app.config
 * @since			CakePHP v 0.10.8.2117
 * @version			$Revision: 2951 $
 * @modifiedby		$LastChangedBy: phpnut $
 * @lastmodified	$Date: 2006-05-25 17:12:33 -0500 (Thu, 25 May 2006) $
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
 
//Intersects arrays by key and then sorts according to array2's order
function array_intersect_key_and_sort($array1, $array2) {
	$array3 = array();
	foreach($array2 as $value) {
		$splitValue = explode('.',$value);
		if($splitValue[0] == $value)
			$array3[$value] = @$array1[$splitValue[0]];
		else
			$array3[$value] = @$array1[$splitValue[0]][$splitValue[1]]; 
	}
	return $array3;
}

// http://www.php.net/manual/en/function.array-flip.php#54417
function array_invert($arr) {
   $flipped = array();
   foreach(array_keys($arr) as $key) {
      if(array_key_exists($arr[$key],$flipped)) {
         $flipped[$arr[$key]] = array_merge((array)$flipped[$arr[$key]], (array)$key);
      } else {
         $flipped[$arr[$key]] = array($key);
      }
   }
   return $flipped;
}

function order($items, $text_direction) {
	return $text_direction != 'ltr' ? array_reverse($items) : $items;
}

/*
function text_direction($text_direction) {
	$arguments = func_get_args();
	return implode(order($arguments));
}
*/

// See https://trac.cakephp.org/ticket/3603
function stringToSlug($string) {
	$string = strip_tags($string);
	$string = mb_strtolower($string, 'UTF-8');
	
	$string = preg_replace('|-+|', '-', $string);
	$string = preg_replace('/&.+?;/u', '', $string); // kill entities
	$string = preg_replace('/\s?\/\s?/u', '-', $string);
	$string = preg_replace('/\s+/u', '-', $string);
	$string = str_replace(':', '-', $string);
	$string = str_replace('--', '-', $string);
	$string = str_replace('\'', '', $string);
	$string = trim($string, ' -');

	//$string = low(trim(str_replace(':','',$string)));
	//$string = @mb_convert_encoding($string, 'HTML-ENTITIES', 'utf-8');   

	//setlocale(LC_CTYPE, 'C');

	//$unPretty = array('/\s?-\s?/u', '/\s?_\s?/u', '/\s?\/\s?/u', '/\s?\\\s?/u', '/\s/u', '/"/u', '/\'/u');
	//$pretty   = array('-', '-', '-', '-', '-', '', '');
		
	//$string = preg_replace(array('/[^\w\s]/', '/\\s+/') , array(' ', '-'), $string);
	
	return $string; // low(...)
}

function replaceFirst($search, $replace, $subject){
    if ($pos = strpos($subject, $search)){
        return substr($subject, 0, $pos) . $replace . substr($subject, $pos + strlen($search));
    } else {
        return $subject;
    }
}

function relativize_url($here,$there) {
	//pr($here);pr($there);
	
	$here = parse_url($here);

	if($here['path'] == '/')
		return $there;
	
	if(strpos($there,$here['path']) === 0) {
		if(strrpos($there,'/') == strlen($there) - 1)
			return str_replace($here['path'],'',$there);		
		else {
			$parts = explode('/',$here['path']);
			$lastPart = end($parts);
			return $lastPart . str_replace($here['path'],'',$there);			
		}
	} else {
		/*
		$tmpHere = explode($here);
		$tmpThere = explode($there);
		
		for($x = 0;$x < size($here) && $x < size($there);$x += 2) {
			//if()
		}
		*/
	}
	
	$depth = substr_count($here['path'],'/');
	
	$relative_path = $depth > 1 ? str_repeat('../',$depth - 1) : '/';
	
	if($there[0] != '/') {
		throw new Exception('relativize function expects absolute URL.');
	} else {
		return substr_replace($there,$relative_path,0,1);
	}
}

function prd($var) {
	pr($var);
	die;
}

function scandir_excluding_dirs($dir) {
	if(!file_exists($dir))
		return false;

	$files = scandir($dir);
	
	if(sizeof($files) < 3)
		return false;
		
	$files2 = array();
	foreach($files as $file) {
	    if(is_dir($dir . DS . $file) || $file == "." || $file == "..")
	    	continue;
		$files2[] = $file;
	}
	
	return $files2;
}

Configure::load('config');

if (!Configure::read('App.name'))
	Configure::write('App.name',__('Great Commission Learning Management System', true));