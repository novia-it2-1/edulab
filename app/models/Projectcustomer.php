<?php
class Edulab_Model_Projectcustomer extends Zend_Db_Table_Abstract
{
	protected $_name = 'projects_customers_link';
	
	public function getProjectCustomers($project_id = null, $is_main_customer)
	{
		$select = $this->select();
		$select->setIntegrityCheck(false)->from(array('p' => $this->_name),array());
		if(!is_null($is_main_customer))
		{
			$this->project_id = $project_id;
			$this->is_main_customer = $is_main_customer;
			$select	->joinLeft(array('c' => 'customers'),'p.customer_id = c.customer_id',array('fullname','unit','phone','mail'))
					->where('project_id = ?', $project_id)
					->where('is_main_customer = ?', $is_main_customer);
			return $this->fetchAll($select);
		}
		return false;
	}
		
	
	public function addProjectcustomer($project_id,$customer_id,$is_main_customer	)
	{
		$data = array("project_id"=>$project_id,
					  "customer_id"=>$customer_id,
					  "is_main_customer"=>$is_main_customer
					 );
					  $this->insert($data);
	}
	public function deleteProjectcustomer($customer_id)
	{
					  
		$where = "customer_id = ".$customer_id;
					  
					  $this->delete($where);
	}
}
?>