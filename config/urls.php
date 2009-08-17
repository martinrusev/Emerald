<?php
$urlpatterns = array
(
	/** WELCOME APP **/
	'^todo\/new\/$' => array('path' => 'welcome/tasks/new_tasklist', 'method' => 'get'),
	'^todo\/delete_task\/(\d{1})\/(\d+)\/$' => array('path' => 'welcome/tasks/new_tasklist', 'method' => 'get')
	
);
