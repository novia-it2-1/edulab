<?php
class Edulab_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initView()
	{
		// Initialize view
		$view = new Zend_View();
		$view->skin = "default";
		
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
		
		// Return it so that it can be stored by the bootstrap
		return $autoLoader;
	}
}
?>