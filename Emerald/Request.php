<?php 
class Emerald_Request
{
	
	function __construct($url_to_parse, $base_url)
	{
		
		$explode = explode('/', $url_to_parse);
		$explode_base = explode('/', $base_url);
		$key = array_search(end($explode_base), $explode);
		
		$this->current_url =  implode('/',array_slice($explode, (int)$key+1));
	}
	
	
	function __toString()
	{
		return $this->current_url;
	}
	
	
}
/* End of the file Request.php */