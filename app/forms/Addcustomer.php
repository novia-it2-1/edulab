<?php

class Edulab_Form_Addcustomer extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');
		

        $customer_id = $this->createElement('hidden','customer_id');
        $fullname = $this->createElement('text','fullname');
        $fullname ->setLabel('Name:')
               ->setAttrib('size',50)
			   ->setRequired(true)
			   ->addValidator('alpha');
        $unit = $this->createElement('text','unit');
        $unit->setLabel('Unit:')
					->setAttrib('size',6)
					->setRequired(true)
					->addValidator('alnum');
        $phone = $this->createElement('text','phone');
        $phone	->setLabel('Phone:')
				->addValidator('Digits')
				->setAttrib('size',10);
		$mail = $this->createElement('text','mail');
        $mail	->setLabel('Mail:')
				->setAttrib('size',40);
		$gender = $this->createElement('radio','gender');
        $gender	->setLabel('Gender:')
				->addMultiOptions(array(
                    0 => 'Male',
                    1 => 'Female' 
                        ))
				->setSeparator('')
				->setRequired(true);
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('submit');

        $this->addElements(array(
			$customer_id,
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