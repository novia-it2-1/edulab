<?php

class Edulab_Form_Addprojectcustomer extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$this->setAction($baseUrl . '/admin/projectcustomer/mode/save');

        $project_id = $this->createElement('hidden','project_id');
        $table = new Edulab_Model_Customer();
		$customers = new Zend_Form_Element_Select('customer_id');
		$customers	->setLabel('Customer:')
					->setRequired(true);
		foreach ($table->getCustomers() as $c) 
		{
		$customers->addMultiOption($c->customer_id, $c->fullname);
		}
		$check = new Zend_Form_Element_Checkbox('is_main_customer');
		$check -> setLabel('Main Contact')
				->setCheckedValue(1)
				->setUncheckedValue(0);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('submit');

        $this->addElements(array(
			$project_id,
            $customers,
			$check,
			$submit
        ));
    }
}
?>