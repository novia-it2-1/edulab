<?php
class Edulab_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initView()
	{
		// Initialize view
		$view = new Zend_View();
		$view->skin = "default";
		Zend_Dojo::enableView($view);
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		// Add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);
		
		// Return it, so that it can be stored by the bootstrap
		return $view;	
	}
	
	protected function _initAutoload()
	{
		$autoLoader = new Zend_Application_Module_Autoloader(array(
			'basePath' => APPLICATION_PATH,
			'namespace' => 'Edulab_',
		));
		
		$acl = new Edulab_Model_EdulabAcl;
		$auth = Zend_Auth::getInstance();
		
		$fc = Zend_Controller_Front::getInstance();
		$fc->registerPlugin(new Edulab_Model_AccessCheck($acl, $auth));
				
		// Return it so that it can be stored by the bootstrap
		return $autoLoader;
	}
}
?>