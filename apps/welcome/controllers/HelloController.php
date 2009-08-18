<?php 

class HelloController extends Controller
{
	
	function __construct($app)
	{
		parent::Controller($app);	
	}
	
	
	/** get "/" */
	function home_page($params = null)
	{
		$data['emerald'] = 'Emerald';
		
		
		
		$this->render_file('hello', $data);
	
	}
	
	
	/** get "/hello/:world/" */
	function martin($params = null)
	{
		$data['string'] = $params[0];
		
		$this->render_file('params', $data);
		
	
	}
	
	
	function new_tasklist()
	{
		
		$this->render_file('empty');
	}
	
	
	
	
	
		
	
	
}
