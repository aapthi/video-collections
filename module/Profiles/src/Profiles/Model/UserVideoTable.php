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
		//print_r($user_id);exit;
		$id=base64_decode($user_id);
		foreach($us_video['video'] as $video)
		{
		$data = array(
			'v_user_id'  	         => $id,
			'v_video_link'  	         => $video,
			'v_created_at'       => date('Y-m-d H:i:s'),	
			'v_updated_at'       => date('Y-m-d H:i:s'),
			//'v_status'           => 0
		);
		$insertresult=$this->tableGateway->insert($data);
		}
		return $this->tableGateway->lastInsertValue;
	}
	public function delUserSkills($uid){
		$row = $this->tableGateway->delete(array('us_user_id' => $uid));
		return $row;
	}
	public function videoList($id)
    {
		$u_id = base64_decode($id);		
//print_r($id);exit;	
		$select = $this->tableGateway->getSql()->select();
		$select->where('vc_user_videos.v_user_id="'.$u_id.'"');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
}