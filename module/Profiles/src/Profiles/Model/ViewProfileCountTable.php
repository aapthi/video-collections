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

class ViewProfileCountTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }		
	public function addViewCount($vpc_pu_id,$vpc_vu_id,$vpc_count)
	{
		$getCount=$this->getUserCount($vpc_pu_id,$vpc_vu_id);
		if($getCount!=""){
			$viewUid = $getCount->vpc_vu_id;
			$vpc_id  = $getCount->vpc_id;
			$vpc_count  = $getCount->vpc_count + $vpc_count;
			$data = array(
				'vpc_count'  	         => $vpc_count,
				'vpc_updated_at'         => date('Y-m-d H:i:s'),
			);
			$updateresult=$this->tableGateway->update($data, array('vpc_id' => $vpc_id));
			return $updateresult;	
		}else{
			$data = array(
				'vpc_pu_id'  	         => $vpc_pu_id,
				'vpc_vu_id'  	         => $vpc_vu_id,
				'vpc_count'  	         => $vpc_count,
				'vpc_created_at'         => date('Y-m-d H:i:s'),
				'vpc_updated_at'         => date('Y-m-d H:i:s'),
			);
			$insertresult=$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;
		}
	}
	public function getUserCount($prfileUid,$loggedUid){
		$select = $this->tableGateway->getSql()->select();
		$resultSet = $this->tableGateway->selectWith($select);
		$select->where('vpc_pu_id="'.$prfileUid.'"');		
		$select->where('vpc_vu_id="'.$loggedUid.'"');		
		return $resultSet->current();	
	}	
	public function delUserSkills($uid){
		$row = $this->tableGateway->delete(array('us_user_id' => $uid));
		return $row;
	}
	public function getViewCount($id)
    {		
		$select = $this->tableGateway->getSql()->select();
		$resultSet = $this->tableGateway->selectWith($select);
		$select->where('vpc_pu_id="'.$id.'"');		
		return $resultSet;
	}

}