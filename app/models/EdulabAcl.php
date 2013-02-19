<?php
class Edulab_Model_EdulabAcl extends Zend_Acl
{
	public function __construct()
	{
		$this->add(new Zend_Acl_Resource('admin'));
		$this->add(new Zend_Acl_Resource('login'), 'admin');
		$this->add(new Zend_Acl_Resource('error'));
		
		$this->addRole(new Zend_Acl_Role('usr'));
		$this->addRole(new Zend_Acl_Role('adm'), 'usr');
		
		$this->allow('usr', 'login');
		$this->allow('adm', 'admin', 'error');
	}
}
?>