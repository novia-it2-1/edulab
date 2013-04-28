<?php
class IndexController extends Zend_Controller_Action
{	
	public function init()
	{
		$layout = Zend_Layout::getMvcInstance();
		$layout->setLayout('default');
		
		$this->view->headTitle('Edulab');
	}

	// index/index
	public function indexAction()
	{
		$projects = new Edulab_Model_Project();
		$id = $this->getRequest()->getParam('id');
		if($project = $projects->getProjectByKey($id))
		{
			$this->view->project = $project;
			$this->view->parts = $projects->getParts($project->project_id);
			
			$existing = new Edulab_Model_Projectcustomer();
			$customers = $existing->getProjectCustomers($project->project_id, 0)->toArray();
			$maincustomer = $existing->getProjectCustomers($project->project_id, 1)->toArray();
			$this->view->customers = $customers;
			$this->view->maincustomer = $maincustomer;
		}
		else
		{
			throw new Zend_Controller_Action_Exception('404 Page not found!', 404);
		}
	}
}
?>