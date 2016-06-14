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

class ProfileTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }	
	public function UsersList()
    {
		
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_user_details.u_id=user.user_id',array('*'),'left');		
		$select->join('vc_cities', 'vc_user_details.city=vc_cities.c_id',array('*'),'left');		
				
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
	public function UserImagesList()
    {
		
		$select = $this->tableGateway->getSql()->select();
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
	
	public function videoTitleList($paginator=false,$cid){
		
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_cities', 'vc_user_details.city=vc_cities.c_id',array('*'),'left');		
		$select->order('vc_user_details.ud_id DESC');		
		$resultSet = $this->tableGateway->selectWith($select);
		$paginatorAdapter = new DbSelect(
				$select,
				$this->tableGateway->getAdapter(),
				$resultSet
			);
			$paginator = new Paginator($paginatorAdapter);
			return $paginator;
		return $resultSet;
		/* $select = $this->tableGateway->getSql()->select();				
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet; */
		
	}
	public function getSearchResults($searcKey,$paginated=false){
		print_r($searcKey);
		print_r($searcKey['search_name']);
		$select = $this->tableGateway->getSql()->select();				
		$select->where(array(
			new \Zend\Db\Sql\Predicate\Expression("MATCH(first_name) AGAINST ('".$searcKey['search_name']."')")
		));
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
	public function UsersProfileList($id)
	{
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_user_details.u_id=user.user_id',array('*'),'left');
		$select->join('vc_cities', 'vc_user_details.city=vc_cities.c_id',array('*'),'left');
		$select->where('vc_user_details.u_id="'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
	public function EditProfile($base_user_id)
	{
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_user_details.u_id=user.user_id',array('*'),'left');		
		$select->join('vc_cities', 'vc_user_details.city=vc_cities.c_id',array('*'),'left');		
		$select->join('vc_user_videos', 'vc_user_details.u_id=vc_user_videos.v_user_id',array('*'),'left');		
		$select->where('vc_user_details.u_id="'.$base_user_id.'"');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
		//print_r($resultSet);exit;
	}
	public function UpdateProfile($users,$user_id)
	{
		//print_r($user);exit;
		if($user_id!=""){
			$data = array(
				'fb_profile_link'  	=> $users['fb'],
				'city'         => $users['city'],
				'first_name'  => $users['fname'],	
				'updated_at'  => date('Y-m-d H:i:s')	
			);
			$updateresult=$this->tableGateway->update($data, array('u_id' => $user_id));
			return $updateresult;
		}
	}
	public function UpdateUserD($user,$user_id,$target_file)
	{
		$lang = implode(',', $user['lang']);
		$data = array(			 		
			'first_name'       => $user['fname'], 	
			'home_phone'       => $user['home'], 	
			'work_phone'       => $user['work'], 	
			'ph_pub_pri'       => $user['ph'], 	
			'work_pub_pri'     => $user['work_phno'], 	
			'home_pub_pri'     => $user['home_phno'], 	
			'user_photo' 	   => $target_file, 	
			'city' 	           => $user['city'], 	
			'languages' 	   => $lang, 	
			'fb_profile_link'  => $user['fb'], 	
			'message' 	       => $user['msg'], 	
			'updated_at' 	   => date('Y-m-d H:i:s')
		);
		$updateresult=$this->tableGateway->update($data, array('u_id' => $user_id));
		return $updateresult;
	}	
}