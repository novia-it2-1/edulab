<?php
class Edulab_Model_AccessCheck extends Zend_Controller_Plugin_Abstract
{
	private $_acl = null;
	private $_auth = null;
	
	public function __construct(Zend_Acl $acl, Zend_Auth $auth)
	{
		$this->_acl = $acl;
		$this->_auth = $auth;
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$resource = $request->getControllerName();
		$action = $request->getActionName();
		
		$id = $this->_auth->getStorage()->read();
		
		if(is_object($id))
		{
			$role = $id->role;
		}
		else
		{
			$role = 'user';
		}
		
		if(!$this->_acl->isAllowed($role, $resource, $action))
		{
			$request->setControllerName('admin')
					->setActionName('login');
		}
	}
}
?>