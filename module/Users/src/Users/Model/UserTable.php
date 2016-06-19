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
				'state'  	=>'1',
				'updated_at' 	=> date('Y-m-d H:i:s')
				);
		$updateuserid=$this->tableGateway->update($data, array('user_id' => $data['user_id']));
		return 	$updateuserid;			
	}
	public function todayUsersCount(){
		$todayDate = date('Y-m-d');
		$select = $this->tableGateway->getSql()->select();	
		$select->where('user.added_date="'.$todayDate.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->count();	
	}
	public function listUsers(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_details', 'vc_user_details.u_id=user.user_id',array('*'),'left');	
		$select->join('vc_view_profiles_count', new Expression('vc_view_profiles_count.vpc_pu_id=user.user_id'),array('userPoints' => new Expression('COALESCE((SUM(vc_view_profiles_count.vpc_count)),0)')),'left');
		$select->where('user.username!="Administration"');
		$select->order('user.user_id DESC');	
		$select->group('user.user_id');	
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function getUserDetails($user_id){
		$select = $this->tableGateway->getSql()->select();		
		$select	->join('vc_user_details', 'user.user_id=vc_user_details.u_id',array('*'),'left');		
		$select->where('user.user_id="'.$user_id.'"');	
		$resultSet = $this->tableGateway->selectWith($select);	
		return $resultSet;		
	}
	public function changeAccountStatus( $user, $type)
    {
		if( $type=='update' ){
			$data = array(
				'updated_at'   	=> date('Y-m-d H:i:s'),				
				'state' 	    => $user['status']
			);	
		}else if($type=='del'){
			$data = array(
				'updated_at' 	=> date('Y-m-d H:i:s'),   			
				'state' 	    => $user['status']
			);		
		}else{
			$data = array(
				'created_at' 	=> date('Y-m-d H:i:s'),   			
				'state' 	    => $user['status']
			);		
		}
		$row=$this->tableGateway->update($data, array('user_id' => $user['userId']));
		return $row;
	}
	public function updateUser($users,$user_id){
		$data = array(
			'contact_number'  	=> $users['phno'],
			'username'          => $users['fname'],
			'display_name'      => $users['fname'],	
			'updated_at'        => date('Y-m-d H:i:s')	
		);	
		$updateresult=$this->tableGateway->update($data, array('user_id' => $user_id));
		return $updateresult;	
	}
	public function addUser($users,$user_id)
    {
		if($user_id!=""){
			$data = array(
				'contact_number'  	=> $users['user_mobile'],
				'username'         => $users['user_first_name'],
				'display_name'  => $users['user_first_name'],	
				'updated_at'  => date('Y-m-d H:i:s')	
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
				'username' 	    => $fisrt_name, 	
				'email' 		=> $users['user_email'],  		
				'password' 		=> $password, 	
				'contact_number'=> $users['user_mobile'],  	
				'display_name'  => $fisrt_name,  	
				'created_at' 	=> date('Y-m-d H:i:s'),   
				'added_date' 	=> date('Y-m-d'),   
				'state' 		=> 0,  		
				'user_type' 	=> 2,  		
				'captch_code' 	=> $users['user_captcha'],  		
			);
			$insertresult=$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;
		}					
    }
	public function updateAddedDate($user_id,$userName){
		$data = array(
			'added_date' 	=> date('Y-m-d'),  		
			'username'   	=> $userName  		
		);
		$updateresult=$this->tableGateway->update($data, array('user_id' => $user_id));
		return $updateresult;
	}
	public function checkDetailsRecorded($user_id)
    {
		$select = $this->tableGateway->getSql()->select();
		$select->columns(array('countUser' => new \Zend\Db\Sql\Expression('COUNT(*)')));
		$select->where('user_id="'.$user_id.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		return $row;
	}	
	public function checkUserStatus($userid){
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_details', 'vc_user_details.u_id=user.user_id',array('*'),'left');	
		$select->where('user.user_id="'.$userid.'"');
		$select->where('user.state="1"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->current();
	}
	public function adStatus($userid){
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_details', 'vc_user_details.u_id=user.user_id',array('*'),'left');	
		$select->where('user.user_id="'.$userid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->current();
	}
	public function checkAdminEmailExists( $userInfo )
    {
		$select = $this->tableGateway->getSql()->select();		
		$select->where('user.email="'.$userInfo['inputEmail'].'"');
		$select->where('user.password="'.md5($userInfo['password']).'"');
		$select->where('user.state=1');
		$select->where('user.user_type=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		return $row;
	}
	public function checkEmailExists( $userInfo )
    {
		$select = $this->tableGateway->getSql()->select();		
		$select->where('user.email="'.$userInfo['inputEmail'].'"');
		$select->where('user.password="'.md5($userInfo['password']).'"');
		$select->where('user.state=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		return $row;
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
		$select->where('email = "'.$email.'"');
		$resultSet = $this->tableGateway->selectWith($select);				
        return $resultSet;
	}
	public function getUser( $userId )
    {
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_details', 'vc_user_details.u_id=user.user_id',array('*'),'left');	
		$select->where('user.user_id="'.$userId.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		return $row;
	}
	public function fpcheckEmail($email)
    {	
		$select = $this->tableGateway->getSql()->select();			
		$select->where('email="'.$email.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->count();
		return $row;
	}
	public function allUsersData($catid,$cid,$username){
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_details', 'vc_user_details.u_id=user.user_id',array('*'),'left');	
		$select->join('vc_cities','vc_user_details.city=vc_cities.c_id',array('*'),'left');	
		$select->join('vc_user_skills','user.user_id=vc_user_skills.us_user_id',array('*'),'left');	
		if($catid!='0'){
			$select->where('vc_user_skills.us_u_c_id="'.$catid.'"');
		}
		if($cid!='0'){
			$select->where('vc_user_details.city="'.$cid.'"');
		}
		if($username!='0'){
			$select->where(array(
				new \Zend\Db\Sql\Predicate\Expression("MATCH(username) AGAINST ('".$username."')")
			));
		}
		$select->where('user.state="1"');
		$select->where('user.user_type="2"');
		$select->group('user.user_id');
		$resultSet = $this->tableGateway->selectWith($select);
		$paginatorAdapter = new DbSelect(
				$select,
				$this->tableGateway->getAdapter(),
				$resultSet
			);
			$paginator = new Paginator($paginatorAdapter);
			return $paginator;
		return $resultSet;
	}
}