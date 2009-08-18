<?php

class Controller
{
	
	function Controller($app = null)
	{
		
		$this->path = EMERALD_APPS . EMERALD_DS . $app . EMERALD_DS . 'templates' .EMERALD_DS;
		
	}
	
	/*
     * Render single file.
     * @param  string   $filename   Name of the file to render
     * @param  array    $bindings   User variables
     */
	public function render_file($filename, $variables = array())
    {
    	
        ob_start();
		foreach($variables as $key => $value)
		{
			$$key = $value;
			
		}
        require $this->path . $filename . '.php';
        ob_end_flush();
    }
	
	
	/*
     * Render multiple files.
     * @param  string   $filenames   Array with files to render
     * @param  array    $variables   User variables
     */
	public function render_files($filenames=array(), $variables = array())
    {
    	
        ob_start();
		foreach($filenames as $file)
		{
			
			foreach($variables as $key => $value)
			{
				
			$$key = $value;
			
			}
        	require $this->path . $file . '.php';
			
			
			
		}
        ob_end_flush();
		
    }
	
	public function render_raw($string)
	{
		
		 ob_start();
		 echo $string;	
         ob_end_flush();
		
		
	}
	
	

	
	
}
