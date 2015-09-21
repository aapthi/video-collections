<?php
namespace Application\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Expression;

class LikeTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }

	public function addlikesDetails($data)
    {	
		$userId=$_SESSION['user']['user_id'];
		$data = array(
			'liked_from' 	 => $userId, 
			'issue_id' 	     => $data['issue_id'],
			'status' 	     => 1,
			'created_at' 	 => date('y-m-d'),
			'modified_at' 	 => date('y-m-d'),
			'like_value' 	 => $data['like_type'],
		);	
		$this->tableGateway->insert($data);		
		return $this->tableGateway->lastInsertValue;
    }

	public function checkUserLikesExits($data)
    {
		$userId=$_SESSION['user']['user_id'];
		$select = $this->tableGateway->getSql()->select();
		$select->where('tbl_likes.liked_from="'.$userId.'"');
		$select->where('tbl_likes.issue_id="'.$data['issue_id'].'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	
	public function updateLikedDetails($data,$likeId)
    {	
		$data = array(
			'like_value' 	         => $data['like_type'],
		);	
		$row=$this->tableGateway->update($data, array('liked_id' => $likeId));
		return $row;
	}
}