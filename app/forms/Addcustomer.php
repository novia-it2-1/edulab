<?php

class Edulab_Form_Addcustomer extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$this->setAction($baseUrl . '/admin/customer/mode/save');

        $id = $this->createElement('hidden','id');
        $fullname = $this->createElement('text','fullname');
        $fullname ->setLabel('Name:')
               ->setAttrib('size',50)
			   ->setRequired(true);
        $unit = $this->createElement('text','unit');
        $unit->setLabel('Unit:')
					->setAttrib('size',6)
					->setRequired(true);
        $phone = $this->createElement('text','phone');
        $phone	->setLabel('Phone:')
				->setAttrib('size',10)
		$mail = $this->createElement('text','mail');
        $mail	->setLabel('Mail:')
				->setAttrib('size',40)
		$gender = $this->createElement('text','gender');
        $gender	->setLabel('Gender:')
				->setAttrib('size',6)
				->setRequired(true);
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('submit');

        $this->addElements(array(
            $fullname,
			$unit,
			$phone,
			$mail,
			$gender,
			$submit
        ));
    }
}
?>