<?php
class Edulab_Model_Customer extends Zend_Db_Table_Abstract
{
	protected $_name = 'customers';	
	
		public function getCustomer($customer_id = null){
		$select = $this->select();
		if(!is_null($customer_id))
		{
			$this->customer_id = $customer_id;
			$select->where('customer_id = ?', $customer_id);
			return $this->fetchRow($select);
		}
		return $this->fetchAll($select);
	}
	
	public function getCustomers($customer_id = null)
	{
		$select = $this->select();
		$select->setIntegrityCheck(false)->from(array('c' => $this->_name));
		$select->joinLeft(array('p' => 'projects_customers_link'),'c.customer_id = p.customer_id' 	);
		if(!is_null($customer_id))
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
	
		public function updateCustomers($customer_id,$fullname,$unit,$phone,$mail,$gender)
	{
		$data = array("fullname"=>$fullname,
					  "unit"=>$unit,
					  "phone"=>$phone,
					  "mail"=>$mail,
					  "gender"=>$gender);
					  
		$where = array("customer_id = ?"=>$customer_id);
					  
					  $this->update($data, $where);
	}
}
?>