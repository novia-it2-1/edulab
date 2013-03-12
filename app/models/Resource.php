<?php
class Edulab_Model_Resource extends Zend_Db_Table_Abstract
{
	protected $_name = 'resources';
	
	public function getResources($part_id = null, $date = null)
	{	
		$select = $this->select();
		$select->setIntegrityCheck(false)->from(array('r' => $this->_name));
		$select->joinLeft(array('p' => 'parts_resources_link'),'r.resource_id = p.resource_id','date');
		if(!is_null($part_id))
		{
			$select->where('p.part_id = ?', $part_id);
		}
		if(!is_null($date))
			{
				$select->where('p.date = ?', $date);
			}
		return $this->fetchAll($select);
	}
	
	public function getResource($resource_id = null)
	{
		$select = $this->select();
		$select->joinRight(array('p' => 'parts_resources_link'),'resource_id = p.resource_id');
		if(!is_null($resource_id))
			{
				$select->where('p.resource_id = ?', $resource_id);
			}
		return $this->fetchAll($select);
	}
	
	public function addResources($name)
	{
		$data = array("name"=>$name);
					  
				$this->insert($data);
	}
	public function deleteResource($resource_id)
	{
					  
		$where = "resource_id = ".$resource_id;
					  
					  $this->delete($where);
	}
}