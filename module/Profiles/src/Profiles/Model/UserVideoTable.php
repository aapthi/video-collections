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

class UserVideoTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }		
	public function UpdateUserVideo($us_video,$user_id)
	{
		$this->delUserVideos($user_id);
		foreach($us_video['video'] as $video)
		{
			if(isset($video) && $video!=""){
				$data = array(
					'v_user_id'  	     => $user_id,
					'v_video_link'  	 => $video,
					'v_created_at'       => date('Y-m-d H:i:s'),	
					'v_updated_at'       => date('Y-m-d H:i:s'),
					'v_status'           => 0
				);			
				$insertresult=$this->tableGateway->insert($data);
			}
		}
		return $this->tableGateway->lastInsertValue;
	}
	public function delUserVideos($uid){
		$row = $this->tableGateway->delete(array('v_user_id' => $uid));
		return $row;
	}
	public function videoList($id)
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('vc_user_videos.v_user_id="'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
	public function videoListAdmin($id)
    {
		$select = $this->tableGateway->getSql()->select();
		$select->join('user', 'vc_user_videos.v_user_id=user.user_id',array('*'),'left');	
		$select->where('vc_user_videos.v_user_id="'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
	public function updateStatus($id,$status){
		$data = array(
			'v_status'  	=> $status,
			'v_updated_at'  => date('Y-m-d H:i:s')	
		);
		$updateresult=$this->tableGateway->update($data, array('v_v_id' => $id));
		return $updateresult;	
	}
}