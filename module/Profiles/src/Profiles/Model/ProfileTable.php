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
		//$select->where('public_or_private="'.$todayDate.'"');
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
		//$select->join('user', 'vc_user_details.u_id=user.user_id',array('*'),'left');
			/* if($cid!=''){
			$select->where('vc_user_details.ud_id="'.$cid.'"');
		} */
		$select->order('vc_user_details.ud_id DESC');
		
		//$select->where('vc_user_details.state="1"');
		//$select->group('user.user_id');
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
		//echo $id;exit;
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_user_details.u_id=user.user_id',array('*'),'left');
		$select->where('vc_user_details.u_id="'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet->current();
	}
	public function EditProfile($base_user_id)
	{
		//echo $base_user_id;exit;
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_user_details.u_id=user.user_id',array('*'),'left');
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
	public function UpdateUser($user,$id)
	{
		print_r($user);
		//print_r($user['video']);
		$skills = implode(', ', $user['state_id']);
		$video = implode(', ', $user['video']);
		//print_r($commaList);exit;
		//echo $user['public'];exit;
		$user_id=base64_decode($id);
		$data = array(			 		
			'first_name'       => $user['fname'], 	
			'public_or_private' 	   => $user['public'], 	
			'user_photo' 	   => '480px-No_Image_Available.png', 	
			'city' 	   => $user['city'], 	
			'fb_profile_link' 	   => $user['fb'], 	
			'message' 	   => $user['msg'], 	
			'video_links' 	   => rtrim($video), 	
			'skills' 	   => $skills, 	
			'created_at'       => date('Y-m-d H:i:s'), 
			'updated_at' 	   => date('Y-m-d H:i:s')
		);
		//print_r($data);exit;
		$updateresult=$this->tableGateway->update($data, array('u_id' => $user_id));
			return $updateresult;
	}
	
}