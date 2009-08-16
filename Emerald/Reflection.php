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
			
			foreach($directory_structure as $key => $value)
			{
				
				$pattern = '/.php/';
				if(preg_match($pattern, $value))
				{
					$controller =  preg_replace($pattern, '', $value);
					
					include($directory . EMERALD_DS . $controller . '.php' );
					
					$reflector = new ReflectionClass($controller);

					$methods = $reflector->getMethods();
					
					
					/** SCANS METHODS IN CONTROLLER **/
					foreach ($methods as $method)
					{
						$method_reflection = new ReflectionMethod($controller, $method->name);
						
						$comments = $method_reflection->getDocComment();
						
						$extract_route = preg_match('/"([^"]+)"/', $comments, $match);
						
						
						if($match[1] == "/" . $current_url)
						{
							
							$data['controller'] = $controller;
							$data['method'] = $method->name;
							$data['path'] = $directory;
							$this->data = $data;
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
