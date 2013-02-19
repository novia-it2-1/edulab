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
		
	//
	// experiment
	// // // // // // // // // // // // // // // // // // // // // // 
	public function loginAction()
	{
		if(Zend_Auth::getInstance()->hasIdentity())
		{
			// temporary redirect
			$this->_redirect('index/index');
		}
		
		$request = $this->getRequest();
				
		$form = new Edulab_Form_LoginForm();
		
		if($request->isPost())
		{
			if($form->isValid($this->_request->getPost()))
			{
				$authAdapter = $this->getAuthAdapter();
		
				$username = $form->getValue('username');
				$password = $form->getValue('password');
		
				$authAdapter->setIdentity($username)
							->setCredential(sha1(md5($password)));
							
				$auth = Zend_Auth::getInstance();
				$result = $auth->authenticate($authAdapter);
				
				if($result->isValid())
				{
					$id = $authAdapter->getResultRowObject();
					
					$authStorage = $auth->getStorage();
					$authStorage->write($id);
					
					// temporary redirect
					$this->_redirect('index/index');
				}
				else
				{
					$this->view->errorMessage = "Username or password is invalid";
				}
			}
		}
			
		$this->view->form = $form;
	}
	
	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		
		// temporary redirection
		$this->_redirect('index/index');
	}
	
	private function getAuthAdapter()
	{
		$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
		
		$authAdapter->setTableName('user')
					->setIdentityColumn('username')
					->setCredentialColumn('password');
					
		return $authAdapter;
	}	
	// // // // // // // // // // // // // // // // // // // // // // 
	// experiment
	//
	
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
	
	public function partAction()
	{
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addpart();
		
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
				$project_id = $form->getValue('project_id');
				$title = $form->getValue('title');
				$comment = $form->getValue('comment');
				$deadline = $form->getValue('deadline');
				$parts = new Edulab_Model_Part();
				$parts->addParts($project_id,$title,$comment,$deadline);
				}
			}
			
			$this->_redirect('admin/part/mode/new');
		}
	}
	
	
	public function resourceAction()
	{
			$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addresource();
		
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
				$name = $form->getValue('name');
				$resources = new Edulab_Model_Resource();
				$resources->addResources($name);
				}
			}
			
			$this->_redirect('admin/resource/mode/new');
		}
	}
	
	public function customerAction()
	{
			$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addcustomer();
		
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
				$fullname = $form->getValue('fullname');
				$unit = $form->getValue('unit');
				$phone = $form->getValue('phone');
				$mail = $form->getValue('mail');
				$gender = $form->getValue('gender');
				$customers = new Edulab_Model_Customer();
				$customers->addCustomers($fullname,$unit,$phone,$mail,$gender);
				}
			}
			
			$this->_redirect('admin/customer/mode/new');
		}
	}
	
	public function resourcedateAction()
	{
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addresourcedate();
		
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
				$date = $form->getValue('date');
				$resource_id = $form->getValue('resource_id');
				$part_id = $form->getValue('part_id');
				
				
				$resourcedates = new Edulab_Model_Partresource();
				$resourcedates->addResourcedates($date,$resource_id,$part_id);
				}
			}
			
			$this->_redirect('admin/resourcedate/mode/new');
		}
	}
	
	public function projectcustomerAction()
	{
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addprojectcustomer();
		
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
				$project_id = $form->getValue('project_id');
				$customers = $form->getValue('customers');
				$is_main_customer = $form->getValue('is_main_customer');
				
				$projectcustomer = new Edulab_Model_Projectcustomer();
				$projectcustomer->addResourcedates($project_id,$customer_id,$is_main_customer);
				}
			}
			
			$this->_redirect('admin/projectcustomer/mode/new');
		}
	}
}


























?>