<?php

class Edulab_Form_Addresourcedate extends Zend_Form
{

public function init()
    {
	
		
        $this->setMethod('post');
        $part_id = $this->createElement('hidden','part_id');
		$table = new Edulab_Model_Resource();
		$resources = new Zend_Form_Element_Select('resource_id');
		$resources	->setLabel('Resource:')
					->setRequired(true);
		foreach ($table->getResources() as $r) 
		{
		$resources->addMultiOption($r->resource_id, $r->name);
		}
		
		/*
        $date = new Zend_Dojo_Form_Element_DateTextBox('date');
		$date = new ZendX_JQuery_Form_Element_Datepicker('date');
		$date->setLabel('Date:');
		*/
		
		$date = $this->createElement('text', 'date');
		$date->setLabel('Date:');
						
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save	');

        $this->addElements(array(
			$part_id,
			$resources,
            $date,
			$submit
        ));
    }
}
?>