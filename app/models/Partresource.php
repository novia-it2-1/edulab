<?php
class Edulab_Model_Partresource extends Zend_Db_Table_Abstract
{
	protected $_name = 'parts_resources_link';
	
	public function addResourcedates($part_id,$resource_id,$date)
	{
		$data = array(
			"part_id"=>$part_id,
			"resource_id"=>$resource_id,
			"date"=>$date
			);
				
				$this->insert($data);
	}
	public function deleteResourcedate($resource_id)
	{
					  
		$where = "resource_id = ".$resource_id;
					  
					  $this->delete($where);
	}
}

?>