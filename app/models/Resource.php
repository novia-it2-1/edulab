<?php
class Edulab_Model_Resource extends Zend_Db_Table_Abstract
{
	protected $_name = 'resources';
	
	public function getResources($part_id = null, $date = null)
	{	
		$select = $this->select();
		$select->joinRight(array('p' => 'parts_resources_link'),'resource_id = p.resource_id');
		if(!is_null($part_id))
		{
			$select->where('p.part_id = ?', $part_id);
		}
		if(!is_null($date_id))
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