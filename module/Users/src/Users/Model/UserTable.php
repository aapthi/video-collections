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

class UserTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function getCurrentUserId()
    {
		$select = $this->tableGateway->getSql()->select();
		$select->columns(array( 'maxUserId' => new Expression('MAX(user_id)')));
		
		$rowset = $this->tableGateway->selectWith($select);
		$row = $rowset->current();
		if( !$row )
		{
			throw new \Exception("Could not retrieve max User Id.");
		}
		
		return $row;
	}
	public function toInsertPassword($user_id,$pwd){
		$password=md5($pwd);
		$data = array(
			'password' 		=> $password, 	
		);
		$updateresult=$this->tableGateway->update($data, array('user_id' => $user_id));		
		return $updateresult;
	}
	public function sentMailToProvUsers($user_id){
		$data = array(
			'sent_mail' 		=> 1, 	
		);
		$resultSet=$this->tableGateway->update($data, array('user_id' => $user_id));		
		return $resultSet;
	}	
	public function updateUserRegAuth($userid){
		$data = array(
				'user_id' 	=>$userid,
				'status'  	=>'1',
				);
		$updateuserid=$this->tableGateway->update($data, array('user_id' => $data['user_id']));
		return 	$updateuserid;			
	}
	public function listUsers(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_details', 'vc_user_details.u_id=vc_users.user_id',array('*'),'left');	
		$select->where('vc_users.user_name!="Administration"');
		$select->where('vc_users.status="1"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function getUserDetails($user_id){
		$select = $this->tableGateway->getSql()->select();		
		$select	->join('vc_user_details', 'vc_users.user_id=vc_user_details.u_id',array('*'),'left');		
		$select->where('vc_users.user_id="'.$user_id.'"');	
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet;		
	}
	public function addUser($users,$user_id)
    {
		if($user_id!=""){
			$data = array(
				'contact_number'  	=> $users['user_mobile'],
				'user_name'         => $users['user_first_name'],	
			);
			$updateresult=$this->tableGateway->update($data, array('user_id' => $user_id));
			return $updateresult;
		}else{
			if($users['user_first_name']!=''){
				$fisrt_name = $users['user_first_name'];
			}else{
				$fisrt_name = '';			
			}
			$password=md5($users['user_password']);
			$data = array(
				'user_name' 	=> $fisrt_name, 	
				'email_id' 		=> $users['user_email'],  		
				'password' 		=> $password, 	
				'contact_number'  => $users['user_mobile'],  	
				'created_at' 	=> date('Y-m-d H:i:s'),   
				'status' 		=> 0,  		
			);
			$insertresult=$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;
		}					
    }		
	public function checkUserStatus($userid){
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_details', 'vc_user_details.u_id=vc_users.user_id',array('*'),'left');	
		$select->where('vc_users.user_id="'.$userid.'"');
		$select->where('vc_users.status="1"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->current();
	}
	public function checkEmailExists( $userInfo )
    {
		$select = $this->tableGateway->getSql()->select();		
		$select->where('vc_users.email_id="'.$userInfo['inputEmail'].'"');
		$select->where('vc_users.password="'.md5($userInfo['password']).'"');
		$select->where('vc_users.status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		return $row;
	}
	public function checkAdminEmailExists( $userInfo )
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('email_id="'.$userInfo['inputEmail'].'"');
		$select->where('password="'.$userInfo['password'].'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}	
	public function getpassword($pwd,$userid){ 
		$pwd=md5($pwd);
		$select = $this->tableGateway->getSql()->select();
		$select->where('password="'.$pwd.'"');
		$select->where('user_id="'.$userid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->count();			
		return $row;
	}
	public function changepwd($pwd,$userid){
		$password=md5($pwd);
		$data = array(
				'user_id'       =>$userid,
				'password'      =>$password,
				);
		$changepassword=$this->tableGateway->update($data, array('user_id' => $data['user_id']));
		return 	$changepassword;	
	}
	public function checkEmail($email)
    {	
		$select = $this->tableGateway->getSql()->select();			
		$select->where('email_id = "'.$email.'"');
		$resultSet = $this->tableGateway->selectWith($select);				
        return $resultSet;
	}
	public function getUser( $userId )
    {
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_details', 'vc_user_details.u_id=vc_users.user_id',array('*'),'left');	
		$select->where('vc_users.user_id="'.$userId.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		return $row;
	}
	public function fpcheckEmail($email)
    {	
		$select = $this->tableGateway->getSql()->select();			
		$select->where('email_id="'.$email.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->count();
		return $row;
	}
	
}