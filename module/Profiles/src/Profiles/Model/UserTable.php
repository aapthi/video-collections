<?php
namespace Profiles\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Expression;

class UserTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }	
	public function UpdateUser($user,$id)
	    {
		//print_r($user);exit;
		$user_id=base64_decode($id);
		$data = array(			 		
			'email'       => $user['email'], 	
			'contact_number' 	   => $user['phno'], 	
			'created_at'       => date('Y-m-d H:i:s'), 
			'updated_at' 	   => date('Y-m-d H:i:s')
		);
		//print_r($data);exit;
		$updateresult=$this->tableGateway->update($data, array('user_id' => $user_id));
			return $updateresult;
	}
	
	
	
	
	
}