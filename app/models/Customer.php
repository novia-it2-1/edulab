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
		return false;
	}
	
	public function getMainCustomer($project_id)
	{
		$select = $this->select();
		if(isset($project_id))
		{
			$select->setIntegrityCheck(false)->from(array('c' => $this->_name));
			$select->joinRight(array('pcl' => 'projects_customers_link'), 'c.customer_id = pcl.customer_id');
			$select->where('pcl.project_id = ?', $project_id);
			$select->where('pcl.is_main_customer = ?', 1);
			return $this->fetchRow($select);
		}
		return false;
	}
	public function getCustomers($project_id = null)
	{
		$select = $this->select();
		$select->setIntegrityCheck(false)->from(array('c' => $this->_name));
		if(!is_null($project_id))
		{
			$this->project_id = $project_id;
			$select->joinLeft(array('p' => 'projects_customers_link'),'c.customer_id = p.customer_id');
			$select->where('project_id = ?', $project_id);
		}
		else
		{
			$select->order('c.fullname','ASC');
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
	public function deleteCustomer($customer_id)
	{
					  
		$where = "customer_id = ".$customer_id;
					  
					  $this->delete($where);
	}
}
?>