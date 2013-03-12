<?php

class Edulab_Form_Addpart extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');

        $project_id = $this->createElement('hidden','project_id');
		$part_id = $this->createElement('hidden','part_id');
        $title = $this->createElement('text','title');
        $title ->setLabel('Title:')
               ->setAttrib('size',50)
			   ->setRequired(true)
			   ->addValidator('Alnum',true);
        $comment = $this->createElement('textarea','comment');
        $comment->setLabel('Comment:')
				->setAttrib('size',50);
        $deadline = new Zend_Dojo_Form_Element_DateTextBox('deadline');
        $deadline	->setLabel('Date:');
		$status = $this->createElement('radio','status');
        $status	->setLabel('Status:')
				->addMultiOptions(array(
                    0 => 'Not Started',
                    1 => 'In Progress',
					2 => 'Finalizing',
					3 => 'Completed' 
                        ))
				->setSeparator('')
				->setRequired(true);
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save');

        $this->addElements(array(
			$project_id,
			$part_id,
            $title,
			$comment,
			$deadline,
			$status,
			$submit
        ));
    }
}
?>