<?php

class Edulab_Form_Addprojectcustomer extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$this->setAction($baseUrl . '/admin/projectcustomer/mode/save');

        $project_id = $this->createElement('hidden','project_id');
		$project_id = setValue(1);
        $table = new Edulab_Model_Customer();
		$customers = new Zend_Form_Element_Select('customer_id');
		$customers	->setLabel('Customer:')
					->setRequired(true);
		foreach ($table->getCustomers() as $c) 
		{
		$customers->addMultiOption($r->customer_id, $c->fullname);
		}
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('submit');

        $this->addElements(array(
			$project_id,
            $customers,
			$submit
        ));
    }
}
?>