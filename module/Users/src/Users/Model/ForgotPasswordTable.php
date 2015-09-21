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

class ForgotPasswordTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function addForgetpwd($forget_id,$email,$userId,$token)
    {
		$data = array(
			'user_id' 	  	=> $userId, 	
			'email' 		=> $email,  		
			'token_id'		=> $token, 
			'status' 		=> 1, 				
			'created_at'    => date('Y-m-d H:i:s'),		
		);
		if($forget_id!=""){
			$this->tableGateway->update($data, array('forget_id' => $forget_id));
		}else{
			$this->tableGateway->insert($data);	
		};	
		return $this->tableGateway->lastInsertValue;
    }
	public function getmailfromfgtpwd($email){
		$select = $this->tableGateway->getSql()->select()			
				->where('email= "'.$email.'"');					 
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function updateForgetPassword($id,$tocken,$userId){
		$data = array(
			'user_id'       =>$userId,
			'token_id'      =>$tocken,
		);
		$changepassword=$this->tableGateway->update($data, array('forget_pwd_id' => $id));
		return 	$changepassword;	
	}
	public function gettoken($token){
		$select = $this->tableGateway->getSql()->select()			
				->where('token_id= "'.$token.'"');					 
		$resultSet = $this->tableGateway->selectWith($select);				
        return $resultSet;		
	}
	public function deletetoken($forget_id){		
		$this->tableGateway->delete(array('forget_pwd_id' => $forget_id));			
        return $this->tableGateway->lastInsertValue;	
	}
	
}