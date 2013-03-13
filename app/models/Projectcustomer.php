<?php
class Edulab_Model_Projectcustomer extends Zend_Db_Table_Abstract
{
	protected $_name = 'projects_customers_link';
	
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