<?php
class AdminController extends Zend_Controller_Action
{	
	public function init()
	{
		$layout = Zend_Layout::getMvcInstance();
		$layout->setLayout('admin');
		
		$this->view->headTitle('Edulab - Admin');
	}

	public function indexAction()
	{
		$projects = new Edulab_Model_Project();
		$this->view->projects = $projects;
		$this->view->customer = new Edulab_Model_Customer();
		$ddresource = new Edulab_Form_Addresourcedate();
		$ddresource ->removeElement('part_id');
		$ddresource ->removeElement('date');
		$ddresource ->removeElement('submit');		
		$this->view->form = $ddresource;
	}
	
	public function mailAction()
	{
		$request = $this->getRequest();
		$id = $request->getParam('id');
		$this->view->id = $id;
		$mailAddress = new Edulab_Model_Customer();
		$email = $mailAddress->getMailAddress($id);
		$this->view->email = $email;
		$mode = $request->getParam('mode');
		if($mode == "send")
		{
			$message = $_POST["message"];
			require_once('Zend/Mail/Transport/Smtp.php');
			require_once ('Zend/Mail.php');
			
			$config = array('port' => 25);
			
			$transport = new Zend_Mail_Transport_Smtp('localhost', $config);
			
			$mail = new Zend_Mail('UTF-8');
			$mail->setBodyText($message . "\n" . "\n" . 'http:// /' . $id);
			$mail->setFrom('root@localhost.com', 'Some Sender');
			foreach($email as $em)
			{
				$mail->addTo($em->mail);
			}
			$mail->setSubject('TestSubject');
			$mail->send($transport);
			echo "<script>window.close();</script>";
		}
		
	}
	
	public function exportAction()
	{
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=report.csv');
		
		$output = fopen('php://output', 'w');

		mysql_connect('localhost', 'root', '');
		mysql_select_db('edulab');
		
		$select1 = mysql_query('SELECT title, description, programmecode, deadline FROM projects');
		$select2 = mysql_query('SELECT * FROM parts');
		$select3 = mysql_query('SELECT * FROM customers');
		
		fputcsv($output, array('Title', 'Description', 'Programmecode', 'Deadline'));
		while ($row = mysql_fetch_assoc($select1)) fputcsv($output, $row);
		fputcsv($output, array(' '));
		
		fputcsv($output, array('Part_id', 'Project_id', 'Title', 'Comment','Status'));
		while ($row = mysql_fetch_assoc($select2)) fputcsv($output, $row);
		fputcsv($output, array(' '));
		
		fputcsv($output, array('Customer_id', 'Name', 'Unit', 'Phone', 'Mail','Gender'));
		while ($row = mysql_fetch_assoc($select3)) fputcsv($output, $row);
		fputcsv($output, array(' '));
		
		exit($output);
	}
	
	public function archiveAction()
	{
		$projects = new Edulab_Model_Project();
		$this->view->projects = $projects;
		$this->view->customer = new Edulab_Model_Customer();
	}
	
	public function loginAction()
	{
		if(Zend_Auth::getInstance()->hasIdentity())
		{
			$this->_redirect('admin');
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
					
					$this->_redirect('admin');
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
				
		$this->_redirect('admin');
	}
	
	private function getAuthAdapter()
	{
		$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
		
		$authAdapter->setTableName('user')
					->setIdentityColumn('username')
					->setCredentialColumn('password');
					
		return $authAdapter;
	}
	
	public function projectAction()
	{
		
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addproject();
		$projects = new Edulab_Model_Project();
		$this->view->customer = new Edulab_Model_Customer();
		$this->view->projects = $projects;
		$this->view->mode = $mode;
		
		if($mode == "new")
		{
			$this->view->page_title = 'New Project';
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			$form->setAction($baseUrl . '/admin/project/new');
			$this->view->page_title = 'New Project';
			$this->view->form=$form;
			
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				$form->populate((array) $formData);
				if($form->isValid($formData))
				{
					$title = $form->getValue('title');
					$description = $form->getValue('description');
					$programmecode = $form->getValue('programmecode');
					$deadline = $form->getValue('deadline');
					
					$projects->addProjects($title,$description,$programmecode,$deadline);
					$this->_redirect('admin');
				}
			}
		}
		elseif($mode == "edit")
		{
			$request = $this->getRequest();
			$id = $request->getParam('id');
			$existing = new Edulab_Model_Projectcustomer();
			$customers = $existing->getProjectCustomers($id, 0)->toArray();
			$maincustomer = $existing->getProjectCustomers($id, 1)->toArray();
			$this->view->customers = $customers;
			$this->view->maincustomer = $maincustomer;
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			$form->setAction($baseUrl . '/admin/project/edit/' . $id);
			$this->view->page_title = 'Edit Project <span>#' . $id . '</span>';
			$project = $projects->getProjects($id,0);
			$data = $project->toArray();
			$form->populate((array) $data);
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				if($form->isValid($formData))
				{
					$id = $form->getValue('project_id');
					$title = $form->getValue('title');
					$description = $form->getValue('description');
					$programmecode = $form->getValue('programmecode');
					$deadline = $form->getValue('deadline');
				
					$projects->updateProjects($id,$title,$description,$programmecode, $deadline);
					$this->_redirect('admin/project/edit/' . $id);
				}
			}
			$this->view->form = $form;
			$this->view->project = $project;
			$this->view->parts = $projects->getParts($id);
		}
		elseif($mode == "delete")
		{
			$delete = new Edulab_Model_Project();
			$request = $this->getRequest();
			$id = $request->getParam('id');
			$delete->deleteProject($id);
			$this->_redirect('admin');
		}
		elseif($mode == "archive")
		{
			$archive = new Edulab_Model_Project();
			$request = $this->getRequest();
			$id = $request->getParam('id');
			$archive->archiveProject($id);
			
			$this->_redirect('admin/archive');
			
		}
	}
	
	public function partAction()
	{
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addpart();
		$parts = new Edulab_Model_Part();
		
		if($mode == "new")
		{
			$form->removeElement('status');
			$request = $this->getRequest();
			$id = $request->getParam('id');
			$this->view->page_title = 'New Part for Project <span>#' . $id . '</span>';
			$data = array('id' => $id);
			$form->populate((array) $data);
			$this->view->form=$form;
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				if($form->isValid($formData))
				{
				$id = $form->getValue('id');
				$title = $form->getValue('title');
				$comment = $form->getValue('comment');
				$deadline = $form->getValue('deadline');
				
				$parts->addParts($id,$title,$comment,$deadline);
				$this->_redirect('admin/project/edit/' .$id);
				}
			}
		}
		elseif($mode == "edit")
		{
			$request = $this->getRequest();
			$id = $request->getParam('id');
			$child_id = $request->getParam('child_id');
			
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			$form->setAction($baseUrl . '/admin/part/edit/' . $id . '/' . $child_id);
			
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				if($form->isValid($formData))
				{
					$part_id = $form->getValue('part_id');
					$title = $form->getValue('title');
					$comment = $form->getValue('comment');
					$deadline = $form->getValue('deadline');
					$status = $form->getValue('status');
				
					$parts->updateParts($part_id,$title,$comment,$deadline,$status);
					$this->_redirect('admin/project/edit/' . $id);
				}
			}
			else
			{
				$data = $parts->getPart($child_id)->toArray();
				$form->populate((array) $data);
			}
			
			$this->view->page_title = 'Edit Part <span>#' . $child_id . '</span> for Project <span>#' . $id . '</span>';
		}
		elseif($mode == "delete")
		{
			$delete = new Edulab_Model_Part();
			$request = $this->getRequest();
			$id = $request->getParam('id');
			$child_id = $request->getParam('child_id');
			$delete->deletePart($child_id);
			$this->_redirect('admin/project/edit/' . $id);
		}
		
		$this->view->id = $id;
		$this->view->form = $form;
	}
	
	
	public function resourceAction()
	{
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addresource();
		if($mode == "new")
		{
			$this->view->form=$form;
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				if($form->isValid($formData))
				{
					$name = $form->getValue('name');
					$resources = new Edulab_Model_Resource();
					$resources->addResources($name);
					$this->_redirect('admin/resource/new');
				}
			}
		}
		elseif($mode == "delete")
		{
			$delete = new Edulab_Model_Resource();
			$request = $this->getRequest();
			$resource_id = $request->getParam('resource_id');
			$delete->deleteResource($resource_id);
		}
	}
	public function customerAction()
	{
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addcustomer();
		$customers = new Edulab_Model_Customer();
		
						
		if($mode == "new")
		{
			$this->view->form=$form;
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
				$customers->addCustomers($fullname,$unit,$phone,$mail,$gender);
				$this->_redirect('admin/customer/new');
				}
			}
		}
		elseif($mode == "edit")
		{
			$request = $this->getRequest();
			$customer_id = $request->getParam('customer_id');
			$data = $customers->getCustomer($customer_id)->toArray();
			$form->populate((array) $data);
			$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
			$form->setAction($baseUrl . '/admin/customer/edit/' . $customer_id);
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				if($form->isValid($formData))
				{
					$customer_id = $form->getValue('customer_id');
					$fullname = $form->getValue('fullname');
					$unit = $form->getValue('unit');
					$phone = $form->getValue('phone');
					$mail = $form->getValue('mail');
					$gender = $form->getValue('gender');
					
					$customers->updateCustomers($customer_id,$fullname,$unit,$phone,$mail,$gender);
					$this->_redirect('admin/customer');
				}
			}
			$this->view->form=$form;
		}
		elseif($mode == "delete")
		{
			$delete = new Edulab_Model_Customer();
			$request = $this->getRequest();
			$customer_id = $request->getParam('customer_id');
			$delete->deleteCustomer($customer_id);
			$this->_redirect('admin/customer');
		}
	}
	
	public function resourcedateAction()
	{
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$form = new Edulab_Form_Addresourcedate();
		$resourcedates = new Edulab_Model_Partresource();
		if($mode == "new")
		{
			$request = $this->getRequest();
			$id = $request->getParam('id');
			$data = array('part_id' => $id);
			$form->populate((array) $data);
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				if($form->isValid($formData))
				{
					$part_id = $form->getValue('part_id');
					$resource_id = $form->getValue('resource_id');
					$date = $form->getValue('date');
					$resourcedates->addResourcedates($part_id,$resource_id,$date);
					$this->_redirect('admin/resourcedate/new/' . $id);
				}
			}
			$this->view->form=$form;
		}
		elseif($mode == "delete")
		{
			$delete = new Edulab_Model_Partresource();
			$request = $this->getRequest();
			$resource_id = $request->getParam('resource_id');
			$delete->deleteResourcedate($resource_id);
			$this->_redirect('admin/resourcedate');
		}
	}
	
	public function projectcustomerAction()
	{
		$MainCustomer = new Edulab_Model_Customer();
		$form = new Edulab_Form_Addprojectcustomer();
		$request = $this->getRequest();
		$mode = $request->getParam('mode');
		$id = $request->getParam('id');
		$this->view->id = $id;
		if($mode == "new")
		{
			$checkMain = $MainCustomer->getMainCustomer($id);
			if($checkMain == true)
			{
				$form->removeElement('is_main_customer');
				$is_main_customer = 0;
			}
			$data = array('project_id' => $id);
			$form->populate((array) $data);
			$this->view->form=$form;
			if($this->getRequest()->isPost())
			{
				$formData = $this->_request->getPost();
				if($form->isValid($formData))
				{
					$id = $form->getValue('project_id');
					$customer_id = $form->getValue('customer_id');
					if($checkMain != true)
					{
					$is_main_customer = $form->getValue('is_main_customer');
					}
					$projectcustomer = new Edulab_Model_Projectcustomer();
					$projectcustomer->addProjectcustomer($id,$customer_id,$is_main_customer);
					$this->_redirect('admin/projectcustomer/new/' . $id);
				}
			}
		}
		elseif($mode == "delete")
		{
			$delete = new Edulab_Model_Projectcustomer();
			$request = $this->getRequest();
			$customer_id = $request->getParam('customer_id');
			$delete->deleteProjectcustomer($customer_id);
			$this->_redirect('admin/project/edit/' . $id);
		}
	}
}
?>