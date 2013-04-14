<?php
class Edulab_Model_Part extends Zend_Db_Table_Abstract
{
	protected $_name = 'parts';
	
	
	
	public function getParts($project_id)
	{
		$select = $this->select();
		$select->where('project_id = ?', $project_id);
		return $this->fetchAll($select);
	}
	
	public function getPart($part_id = null)
	{
		$select = $this->select();
		
		if(!is_null($part_id))
		{
			$this->part_id = $part_id;
			$select->where('part_id = ?', $part_id);
			return $this->fetchRow($select);
		}
		return false;
	}
	
	public function addParts($project_id,$title,$comment,$deadline)
	{
		$data = array("project_id"=>$project_id,
					  "title"=>$title,
					  "comment"=>$comment,
					  "deadline"=>$deadline
					  );
					  
					  $this->insert($data);
	}
	public function updateParts($part_id,$title,$comment,$deadline,$status)
	{
		$data = array("title"=>$title,
					  "comment"=>$comment,
					  "deadline"=>$deadline,
					  "status"=>$status
					  );
					  
		$where = array("part_id = ?"=>$part_id);
					  
					  $this->update($data, $where);
	}
	public function deletePart($part_id)
	{
					  
		$where = "part_id = ".$part_id;
					  
					  $this->delete($where);
	}
}
?>