<?php

class Edulab_Form_Addproject extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');
		

        $project_id = $this->createElement('hidden','project_id');
        $title = $this->createElement('text','title');
        $title ->setLabel('Title:')
			   ->setRequired(true)
			   ->addValidator('alnum');
        $description = $this->createElement('textarea','description');
        $description->setLabel('Description:')
					->setRequired(true);
        $programmecode = $this->createElement('text','programmecode');
        $programmecode	->setLabel('Programmecode:')
						->setRequired(true)
						->addValidator('alnum');
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