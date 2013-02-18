<?php
class Edulab_Model_Project extends Zend_Db_Table_Abstract
{
	protected $_name = 'projects';
	public $project_id;
	
	
	public function getProjects($project_id = null, $is_archived = 0){
		
		
		$select = $this->select();
		
		if(!is_null($project_id))
		{
			$this->project_id = $project_id;
			$select->where('project_id = ?', $project_id);
			return $this->fetchRow($select);
		}
		$select->where('is_archived = ?', $is_archived);
		return $this->fetchAll($select);
	}
	
	public function getParts()
	{
		$parts = new Edulab_Model_Part();
		return $parts->getParts($project_id);
	
	}
	
	public function addProjects($title,$description,$programmecode)
	{
		$data = array("title"=>$title,
					  "description"=>$description,
					  "programmecode"=>$programmecode);
					  
					  $this->insert($data);
	}
}
?>