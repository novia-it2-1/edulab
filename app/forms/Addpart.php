<?php

class Edulab_Form_Addpart extends Zend_Form
{

public function init()
    {
        $this->setMethod('post');
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$this->setAction($baseUrl . '/admin/part/mode/save');

        $project_id = $this->createElement('hidden','project_id');
		$project_id -> setValue(1);
        $title = $this->createElement('text','title');
        $title ->setLabel('Title:')
               ->setAttrib('size',50)
			   ->setRequired(true);
        $comment = $this->createElement('text','comment');
        $comment->setLabel('Comment:')
					->setAttrib('size',50);
         $deadline = new Zend_Dojo_Form_Element_DateTextBox('deadline');
        $deadline->setLabel('Date:');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('submit');

        $this->addElements(array(
			$project_id,
            $title,
			$comment,
			$deadline,
			$submit
        ));
    }
}
?>