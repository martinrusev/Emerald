<?php 

class Emerald_Reflection
{
	
	function __construct($current_url, $apps)
	{
		
		$route = $this->find_route_config($current_url, $apps);
		
		if($route == FALSE)
		{
			$this->find_comment_route($current_url, $apps);	
		}
		
		
		
	}
	
	
	/**
	 *  Looks for regular expression matching the current url in url_config.php 
	 *  Sinatra behaviour
	 *  
	 * @param object $current_url
	 * @param object $apps
	 * @return void
	 */
	public function find_route_config($current_url, $apps)
	{
		
		include(EMERALD_CONFIG . EMERALD_DS . 'urls.php');
		
		foreach($urlpatterns as $key => $value)
		{
			
	
			if(preg_match('/' . $key . '/', $current_url))
			{
				
				
				$explode_url_config_path = explode('/', $value['path']);
				$explode_key = explode('/', $key);
				$explode_current_url = explode('/', $current_url);
				
				
				/** ANALYZES URL AND PARSES PARAMETERS **/
				foreach($explode_key as $key => $value)
				{
					
										
					/** MATCHES THE VARIABLES IN () **/
					if(preg_match( '/[\\(\\)]/' , $value, $match))
					{
						$this->params .=  $key;	
					}
					
					/** IF THERE ARE ANY PARAMS **/
					if(isset($this->params) && !empty($this->params))
					{
						
						$this->param_values = array();
						$filtered_params_keys = str_split($this->params);
						
						foreach($explode_current_url as $url_segment => $param)
						{
							if(in_array($url_segment, $filtered_params_keys))
							{
								$this->param_values[] .= $param;
							
							}
						}
						
					}
					
					
					
				}
				
				
				if(isset($this->param_values) && !empty($this->param_values))
				{
					$data['params'] = $this->param_values;
				}
				else
				{
					$data['params'] = '';
				}
				
				$data['controller'] = ucfirst($explode_url_config_path[1]) . 'Controller';
				$data['method'] = $explode_url_config_path[2];
				$data['path'] = $value['path'];
				$data['app'] = $explode_url_config_path[0];
				$this->data = $data;
				
				
				
			}
			
			
		}
		
			return FALSE;
		
		
		
		
	}
	
	
	/**
	 *  Scans directory structure and looks for routes in the function comments
	 *  Sinatra behaviour
	 *  
	 * @param object $current_url
	 * @param object $apps
	 * @return void
	 */
	public function find_comment_route($current_url, $apps)
	{
		
		/** FIND THE ROUTE **/
		foreach($apps as $app => $value)
		{
			
			$directory = EMERALD_APPS  . EMERALD_DS . $value . EMERALD_DS . 'controllers';
			
			$directory_structure = scandir($directory);
			
			foreach($directory_structure as $key => $file)
			{
				
				$pattern = '/.php/';
				if(preg_match($pattern, $file))
				{
					$controller =  preg_replace($pattern, '', $file);
					include($directory . EMERALD_DS . $controller . '.php' );
					$reflector = new ReflectionClass($controller);
					$methods = $reflector->getMethods();
					
					
					/** SCANS METHODS IN CONTROLLER **/
					foreach ($methods as $method)
					{
						$method_reflection = new ReflectionMethod($controller, $method->name);
						$comments = $method_reflection->getDocComment();
						$extract_route = preg_match('/"([^"]+)"/', $comments, $match);
					
												
						if(isset($match[1]))
						{
							
							$explode_route = explode('/', $match[1]);
							$explode_current_url = explode('/', $current_url);
						
							
							/** TODO rewrite it with real regular expressions **/
							if($explode_route[1] == $explode_current_url[0])
							{
								
								$total_route_params = count($explode_route)-2;
								$total_current_url_params = count($explode_current_url)-1;
								
								/** URL MATCHES ONLY WHEN PARAMS IN CURRENT URL AND DEFINED 
								 * IN THE ROUTE MATCH
								 */
								if($total_current_url_params == $total_route_params)
								{
									$data['params'] = array_slice($explode_current_url, 1, $total_route_params);
									$data['controller'] = $controller;
									$data['method'] = $method->name;
									$data['path'] = $directory;
									$data['app'] = $value;
									$this->data = $data;
									
									
								}
								
								
								
							}
		
							
						}
						
												
					}
				
				}
			
			
			}
		}
		
		return FALSE;
		
	}
	
	
	function __toString()
	{
		if(isset($this->data))
		{
			return $this->data;
		}
		
	
	}
	
	
	
}
