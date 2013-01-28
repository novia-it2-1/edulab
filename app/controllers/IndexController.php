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

	}
}
?>