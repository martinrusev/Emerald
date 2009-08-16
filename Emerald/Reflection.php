<?php 

class Emerald_Reflection
{
	
	function __construct($current_url, $apps)
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
		
		
	}
	
	
	function __toString()
	{
		if(isset($this->data))
		{
			return $this->data;
		}
		
	
	}
	
	
	
}
