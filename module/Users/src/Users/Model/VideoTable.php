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
	public function addVideo($videoData,$browsed_video,$imageUrl,$browsed_imagecode,$uid,$vimage,$vid){		
		if($vid!=''){				
			$data = array(
				'v_cat_id'  	  => $videoData['video_cat'],
				'v_title'  		  => $videoData['video_title'],
				'v_link'  		  => $videoData['video_link'],
				'v_thumb_image'   => $imageUrl,
				'v_desc'          => $videoData['video_desc'],
				'type_of_video'   => $videoData['video_type'],								
				'updated_at'      => date('Y-m-d H:i:s'),
				'browsed_video'   => $browsed_video,
				'browsed_imagecode'   => $browsed_imagecode,
			);
			if(isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id']!=""){
				$data['v_state'] = 0;
			}
			$updateresult=$this->tableGateway->update($data, array('v_id' => $vid));
			return $updateresult;
		}else{
			if(isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id']!=""){
				$status = 0;
			}else{
				$status = 1;
			}
			$data = array(
				'v_user_id'  	  => $uid,
				'v_cat_id'  	  => $videoData['video_cat'],
				'v_title'  		  => $videoData['video_title'],
				'v_link'  		  => $videoData['video_link'],
				'v_thumb_image'   => $imageUrl,
				'v_desc'          => $videoData['video_desc'],
				'type_of_video'   => $videoData['video_type'],
				'v_state'         => $status,
				'created_at'      => date('Y-m-d H:i:s'),
				'added_date'      => date('Y-m-d'),
				'browsed_video'   => $browsed_video,
				'browsed_imagecode'   => $browsed_imagecode
			);
			$insertresult=$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;
		}	
	}
	public function videoListWithCount(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_categories', 'vc_videos.v_cat_id=vc_categories.category_id',array('*'),'left');
		$select->join('vc_hits', 'vc_videos.v_id=vc_hits.hv_id',array('totalHits' =>new Expression('COUNT(h_id)')),'left');
		$select->group('vc_videos.v_id');	
		$select->where('vc_videos.v_state!="2"');		
		$select->order('vc_videos.v_id DESC');	
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function getCategory($vid){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('vc_videos.v_id="'.$vid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->current();	
	}
	public function todayVideoCount(){
		$todayDate = date('Y-m-d');
		$select = $this->tableGateway->getSql()->select();	
		$select->where('vc_videos.added_date="'.$todayDate.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->count();	
	}
	public function presentVideoCount(){
		$select = $this->tableGateway->getSql()->select();	
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->count();	
	}
	public function videoRelatedList($cid,$vid){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('vc_videos.v_cat_id="'.$cid.'"');
		$select->where('vc_videos.v_id!="'.$vid.'"');
		$select->order(new \Zend\Db\Sql\Expression('RAND()'))->limit(100);
		$select->where('vc_videos.type_of_video="featured"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;	
	}
	public function userVideosList($userid){
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_videos.v_user_id=user.user_id',array('*'),'left');	
		$select->join('vc_categories', 'vc_videos.v_cat_id=vc_categories.category_id',array('*'),'left');	
		$select->where('vc_videos.v_user_id="'.$userid.'"');
		$select->where('vc_videos.v_state="1"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function getVideoInfo($vid){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('vc_videos.v_id="'.$vid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->current();
	}
	public function checkvideoLink($videoCode){		
		$select = $this->tableGateway->getSql()->select();	
		$select->where('vc_videos.browsed_imagecode="'.$videoCode.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->count();
	}
	public function videoList(){
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_videos.v_user_id=user.user_id',array('*'),'left');	
		$select->join('vc_categories', 'vc_videos.v_cat_id=vc_categories.category_id',array('*'),'left');
		$select->where('vc_videos.v_state!="2"');		
		$select->order('vc_videos.v_id DESC');	
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
	public function videoUpdatesList(){
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
		$select->limit(16);
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
		$paginatorAdapter = new DbSelect(
				$select,
				$this->tableGateway->getAdapter(),
				$resultSet
			);
			$paginator = new Paginator($paginatorAdapter);
			return $paginator;
		return $resultSet;
	}
	public function getVideoTitle($vid){
		$select = $this->tableGateway->getSql()->select();				
		$select->where('v_id="'.$vid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->current();
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
	public function videoPlay($vid){
		$select = $this->tableGateway->getSql()->select();	
		$select->where('vc_videos.v_id="'.$vid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function homePageVideos(){
		$select = $this->tableGateway->getSql()->select();				
		$select->where('v_state="1"');
		$select->order(new \Zend\Db\Sql\Expression('RAND()'))->limit(30);
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function getSearchResults($searcKey,$paginated=false){
		$select = $this->tableGateway->getSql()->select();	
		$select->order('v_id DESC');	
		$select->where('v_state="1"');		
		$select->where(array(
			new \Zend\Db\Sql\Predicate\Expression("MATCH(v_title) AGAINST ('".$searcKey['search_name']."')")
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
	public function getSearchTilesResults($searcKey,$paginated=false){
		$select = $this->tableGateway->getSql()->select();	
		$select->order('v_id DESC');	
		$select->where('v_state="1"');	
		$select->where(array(
			new \Zend\Db\Sql\Predicate\Expression("MATCH(v_title) AGAINST ('".$searcKey."')")
		));
		$resultSet = $this->tableGateway->selectWith($select);			
		return $resultSet;
	}
}