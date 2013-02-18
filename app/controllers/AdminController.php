<?php
class AdminController extends Zend_Controller_Action
{	
	public function init()
	{
		$layout = Zend_Layout::getMvcInstance();
		$layout->setLayout('admin');
		
		$this->view->headTitle('Edulab - Admin');
	}

	// admin/index
	public function indexAction()
	{
		$this->view->test = "Controller output";
	}
	
	public function projectAction()
	{
		
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addproject();
		
		if($mode == "new")
		{
			$this->view->form=$form;
		}
		elseif($mode == "save")
		{
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				if($form->isValid($formData))
				{
				$title = $form->getValue('title');
				$description = $form->getValue('description');
				$programmecode = $form->getValue('programmecode');
				$projects = new Edulab_Model_Project();
				$projects->addProjects($title,$description,$programmecode);
				}
			}
			
			$this->_redirect('admin/project/mode/new');
		}
	}

}
?>