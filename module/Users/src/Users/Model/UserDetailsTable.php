<?php
namespace Users\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Expression;

class UserDetailsTable
{
    protected $tableGateway;
	protected $select;

	 public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function addDetails($usersinfo,$user_id,$udid){
		$data = array(
			'u_id' 		       => $user_id,  		
			'first_name'       => $usersinfo['user_first_name'], 	
			'last_name' 	   => $usersinfo['user_last_name'], 	
			'user_check_data'  => 1, 	
			'user_photo' 	   => '', 	
			'created_at'       => date('Y-m-d H:i:s'), 
			'updated_at' 	   => date('Y-m-d H:i:s')
		);
		if(isset($udid) && $udid!=""){
			$updateresult=$this->tableGateway->update($data, array('u_id' => $user_id));
			return $updateresult;
		}else{
			$insertresult=$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;	
		}	
		
	}
	public function addUserDetails( $user_id, $type )
    {
		if( $type=='update' ){
			$data = array(
				'updated_at' 	   => date('Y-m-d H:i:s'),
			);	
			$updateresult=$this->tableGateway->update($data, array('u_id' => $user_id));
			return $updateresult;
		}else{
			$data = array(
				'u_id' 	     => $user_id, 
				'created_at' => date('Y-m-d H:i:s')
			);	
			$this->tableGateway->insert($data);		
			return $this->tableGateway->lastInsertValue;
		}
    }
}