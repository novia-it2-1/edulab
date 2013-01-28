<?php
class Zend_View_Helper_LoadSkin extends Zend_View_Helper_Abstract
{
	public function loadSkin($skin)
	{
		// load the skin config file
		$skinData = new Zend_Config_Xml(BP . DS . 'www/skin/' . $skin . '/skin.xml');
		$stylesheets = $skinData->includes->css;
		// append each stylesheet
		if (is_object($stylesheets) && is_array($stylesheets->toArray())) {
			foreach ($stylesheets->toArray() as $stylesheet) {
				$this->view->headLink()->appendStylesheet(ROOT . 'skin/' . $skin . '/css/' . $stylesheet);
			}
		} else {
			$this->view->headLink()->appendStylesheet(ROOT . 'skin/' . $skin . '/css/' . $stylesheets);
		}
		
		$javascripts = $skinData->includes->js;
		// append each javascript
		if (is_object($javascripts) && is_array($javascripts->toArray())) {
			foreach ($javascripts->toArray() as $javascript) {
				$this->view->headScript()->appendFile(ROOT . 'js/' . $javascript);
			}
		} else {
			$this->view->headScript()->appendFile(ROOT . 'js/' . $javascripts);
		}
	}
}