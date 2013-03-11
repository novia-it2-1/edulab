<?php

class Edulab_Form_Addproject extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');
		

        $project_id = $this->createElement('hidden','project_id');
        $title = $this->createElement('text','title');
        $title ->setLabel('Title:')
               ->setAttrib('size',50)
			   ->setRequired(true);
        $description = $this->createElement('text','description');
        $description->setLabel('Description:')
					->setAttrib('size',50)
					->setRequired(true);
        $programmecode = $this->createElement('text','programmecode');
        $programmecode	->setLabel('Programmecode:')
						->setAttrib('size',10)
						->setRequired(true);
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('submit');

        $this->addElements(array(
			$project_id,
            $title,
			$description,
			$programmecode,
			$submit
        ));
    }
}
?>