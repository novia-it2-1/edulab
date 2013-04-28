<?php
class Edulab_Model_Project extends Zend_Db_Table_Abstract
{
	protected $_name = 'projects';
	public $project_id;
	
	public function getProjects($project_id = null, $is_archived = 0)
	{
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
	
	public function getProjectByKey($key)
	{
		$select = $this->select();
		
		if(!is_null($key))
		{
			$select->where('urlkey = ?', $key);
			return $this->fetchRow($select);
		}
		
		return false;
	}
	
	public function getDeadline($project_id = null)
	{
		$select = $this->select();
		if(!is_null($project_id))
		{
			$this->project_id = $project_id;
			$select->where('project_id = ?', $project_id);
			$select->columns('deadline');
			return $this->fetchAll($select);
		}
		return false;
	}
	
	public function getParts($project_id = null)
	{
		$parts = new Edulab_Model_Part();
		return $parts->getParts($project_id);
	}
	
	public function addProjects($title,$description,$programmecode,$deadline)
	{
		$urlkey = substr(0,8,md5(time()));
		while($this->getProjectByKey($urlkey)){
			$urlkey = substr(0,8,md5(time()));
		}
	
		$data = array("title"=>$title,
					  "description"=>$description,
					  "programmecode"=>$programmecode,
					  "deadline" => $deadline,
					  "urlkey" => $urlkey);
					  
					  $this->insert($data);
	}
	
	public function updateProjects($project_id,$title,$description,$programmecode,$deadline)
	{
		$data = array("title"=>$title,
					  "description"=>$description,
					  "programmecode"=>$programmecode,
					  "deadline" => $deadline);
					  
		$where = array("project_id = ?"=>$project_id);
					  
					  $this->update($data, $where);
	}
	public function deleteProject($project_id)
	{
					  
		$where = "project_id = ".$project_id;
					  
					  $this->delete($where);
	}
	public function archiveProject($project_id)
	{
		$data = array("is_archived"=> 1);
		
		$where = "project_id = ".$project_id;
		
		$this->update($data, $where);
	}
}
?>