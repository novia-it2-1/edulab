<?php
class Edulab_Model_User extends Zend_Db_Table_Abstract
{
	protected $_name = 'users';
	
	/**
	* Finds and returns user by ID or username
	*
	* @param string $user
	* @param int $user_id
	* @return User Returns User object or null if not found
	*/
	
	public function getUser($user = null, $user_id = null)
	{
		if(is_null($user) && is_null($user_id))
		{
			return false;
		}
		
		$select = $this->select();
		
		if(!is_null($user))
		{
			$select->where('username LIKE ?', $user);
		}
		
		if(!is_null($user_id))
		{
			$select->where('user_id = ?', $user_id);
		}
		
		return $this->fetchRow($select);
	}
	
	/**
	* Login functionality
	*
	* @param string $userName
	* @param string $userPass
	* @return true if successful login
	*/
		
	public function login($userName = null, $userPass = null)
	{
		$form = new Form_LoginForm();
		$this->view->form = $form;
		
		if(isset($userName) && isset($userPass))
		{
			// get the default db adapter
			$db = Zend_Db_Table::getDefaultAdapter();

			//create the auth adapter
			$authAdapter = new Zend_Auth_Adapter_DbTable($db);
			$authAdapter->setTableName('user')
						->setIdentityColumn('username')
						->setCredentialColumn('password')
						->setIdentity($userName)
						->setCredential(sha1(md5($userPass)));
			
			//authenticate
			$result = $authAdapter->authenticate();

			if ($result->isValid())
			{
				$auth = Zend_Auth::getInstance();
				$storage = $auth->getStorage();
				
				// In array, list the columns wanted in Zend_Auth ( from DB )
				$storage->write($authAdapter->getResultRowObject(array('user_id','username','fullname')));
				
				return true;
			}
			else
			{
				return false;
			}
		}
	}
}