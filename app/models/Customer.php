<?php
class Edulab_Model_Customer extends Zend_Db_Table_Abstract
{
	protected $_name = 'customers';
	
	
	
	public function getCustomers($customer_id = null)
	{
		$select = $this->select();
		$select->joinRight(array('c' => 'projects_customers_link'),'project_id = c.project_id');
		if(!is_null($project_id))
		{
			$this->customer_id = $customer_id;
			$select->where('customer_id = ?', $customer_id);
			return $this->fetchRow($select);
		}
		return $this->fetchAll($select);
		
	}
	
	public function addCustomers($fullname,$unit,$phone,$mail,$gender)
	{
		$data = array("fullname"=>$fullname,
					  "unit"=>$unit,
					  "phone"=>$phone,
					  "mail"=>$mail,
					  "gender"=>$gender);
					  
					  $this->insert($data);
	}
}
?>