<?php 

class TasksController extends Controller
{
	
	function __construct($app)
	{
		parent::Controller($app);	
	}
	
	
	/** get "/hello" */
	function view_tasks($params = null)
	{
		$data['test_data'] = array('test','another_test');
		
		
		$this->render_file('hello');
	
	}
	
	
	/** get "/view_tasklist/:id/:tasklist_id" */
	function view_tasklist($params = null)
	{
		
			
		$this->render_files(array('content', 'footer'), $data);
	
	}
	
	
	function new_tasklist($params=null)
	{
		print_r($params);
		
		$this->render_file('hello');
		
	}
	
	
	
	function delete_task($params = null)
	{
		
			
		//$this->render_file('hello');
	
	}
		
	
	
}
