<?php 

class TasksController extends Controller
{
	
	function __construct($app)
	{
		parent::Controller($app);	
	}
	
	
	/** get "/view_tasks/:tasklist_id/:task_id" */
	function view_tasks($params = null)
	{
		$data['test_data'] = array('test','another_test');
		
		
		$this->render_files(array('header', 'content', 'footer'), $data);
	
	}
	
	
	/** get "/view_tasklist/:id/:tasklist_id" */
	function view_tasklist($params = null)
	{
		
			
		$this->render_files(array('header', 'content', 'footer'), $data);
	
	}
		
	
	
}
