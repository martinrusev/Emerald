<?php 

require('app_config.php');

define( 'EMERALD_APPS', 'apps');
define( 'EMERALD_ROOT' ,'Emerald');
define( 'EMERALD_DS', DIRECTORY_SEPARATOR);

/** LOAD EMERALD CLASSES **/
require(EMERALD_ROOT . EMERALD_DS . 'Reflection.php');
require(EMERALD_ROOT .  EMERALD_DS . 'Request.php');
require(EMERALD_ROOT .  EMERALD_DS . 'Response.php');
require(EMERALD_ROOT .  EMERALD_DS . 'Controller.php');

$current_url =  $_SERVER['REQUEST_URI'];
$route = new Emerald_Request($current_url, $config['base_url']);
$find_route = new Emerald_Reflection($route->current_url, $config['installed_apps']);


	if(is_object($find_route) && !empty($find_route->data))
	{
		
		$controller = new $find_route->data['controller']($find_route->data['app']);
		
		$method = $find_route->data['method'];
		
		$method = $controller->$method($find_route->data['params']);
		
	}
	else
	{
		Response::raise404();
	}




