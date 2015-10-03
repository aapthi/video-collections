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

class HitsTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function addHit($vid,$uid)
    {
		$data = array(
			'hv_id' 	    => $vid, 	
			'hu_id' 		=> $uid,  		
			'h_ip_add' 		=> $uid, 	
			'h_status'      => 1,  	
			'added_date'    => date('Y-m-d H:i:s'),   	
			'updated_date' 	=> date('Y-m-d H:i:s')   
				
		);
		$insertresult=$this->tableGateway->insert($data);
		return $this->tableGateway->lastInsertValue;
    }
	public function alreadyHit($vid,$uid){
		$select = $this->tableGateway->getSql()->select();
		$select->where('vc_hits.hv_id="'.$vid.'"');
		$select->where('vc_hits.hu_id="'.$uid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->count();
		return $row;
	}
	public function todayHitsOnVideo($vid){
		$todayDate = date('Y-m-d');
		$select = $this->tableGateway->getSql()->select();
		$select->where('vc_hits.hv_id="'.$vid.'"');
		$select->where('vc_hits.hit_date="'.$todayDate.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->count();
		return $row;
	}
}