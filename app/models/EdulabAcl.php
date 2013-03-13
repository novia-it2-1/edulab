<?php
class Edulab_Model_EdulabAcl extends Zend_Acl
{
	public function __construct()
	{
		$roles = array('admin', 'user');
		$controllers = array('admin','error','index');
		
		foreach ($roles as $role)
		{
			$this->addRole(new Zend_Acl_Role($role));
		}
		
		foreach ($controllers as $controller)
		{
			$this->add(new Zend_Acl_Resource($controller));
		}
		
		$this->allow('admin');
		$this->allow('user');
		$this->deny('user','admin');
		$this->allow('user','admin',array('login'));
	}
}
?>