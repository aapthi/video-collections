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

class VideoTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function addVideo($videoData,$uid,$vimage,$vid){		
		if($vid!=''){
			$data = array(
				'v_cat_id'  	  => $videoData['video_cat'],
				'v_title'  		  => $videoData['video_title'],
				'v_link'  		  => $videoData['video_link'],
				'v_thumb_image'   => $vimage,
				'v_desc'          => $videoData['video_desc'],
				'type_of_video'   => $videoData['video_type'],
				'v_state'           => "1",
				'updated_at'      => date('Y-m-d H:i:s')
			);
			$updateresult=$this->tableGateway->update($data, array('v_id' => $vid));
			return $updateresult;
		}else{
			$data = array(
				'v_user_id'  	  => $uid,
				'v_cat_id'  	  => $videoData['video_cat'],
				'v_title'  		  => $videoData['video_title'],
				'v_link'  		  => $videoData['video_link'],
				'v_thumb_image'   => $vimage,
				'v_desc'          => $videoData['video_desc'],
				'type_of_video'   => $videoData['video_type'],
				'v_state'           => "1",
				'created_at'      => date('Y-m-d H:i:s')
			);
			$insertresult=$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;
		}	
	}
	public function getVideoInfo($vid){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('vc_videos.v_id="'.$vid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->current();
	}
	public function videoList(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_videos.v_user_id=user.user_id',array('*'),'left');	
		$select->join('vc_categories', 'vc_videos.v_cat_id=vc_categories.category_id',array('*'),'left');	
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function videoForentedList(){
		$select = $this->tableGateway->getSql()->select();				
		$select->order('vc_videos.v_id DESC');		
		$select->where('v_state="1"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function videoFeaturedList(){
		$select = $this->tableGateway->getSql()->select();				
		$select->order('vc_videos.v_id DESC');		
		$select->where('v_state="1"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function videoTitleList($paginated=false,$cid){
		$select = $this->tableGateway->getSql()->select();				
		if($cid!=''){
			$select->where('vc_videos.v_cat_id="'.$cid.'"');
		}
		$select->order('vc_videos.v_id DESC');	
		$select->where('vc_videos.v_state="1"');
		$select->group('vc_videos.v_id');
		$resultSet = $this->tableGateway->selectWith($select);
		echo 
		$paginatorAdapter = new DbSelect(
				$select,
				$this->tableGateway->getAdapter(),
				$resultSet
			);
			$paginator = new Paginator($paginatorAdapter);
			return $paginator;
		return $resultSet;
	}
	public function changeAccountStatus( $user)
    {
	
			$data = array(
				'updated_at' 	=> date('Y-m-d H:i:s'),   			
				'v_state' 	    => $user['status']
			);		
		
		$row=$this->tableGateway->update($data, array('v_id' => $user['vid']));
		return $row;
	}
}