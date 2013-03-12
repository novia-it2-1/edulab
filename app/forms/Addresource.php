<?php

class Edulab_Form_Addresource extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$this->setAction($baseUrl . '/admin/resource/mode/save');

        $id = $this->createElement('hidden','id');
        $name = $this->createElement('text','name');
        $name ->setLabel('Name:')
               ->setAttrib('size',50)
			   ->addValidator('Alnum',true,array('allowWhiteSpace' => true));
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save');

        $this->addElements(array(
            $name,
			$submit
        ));
    }
}
?>