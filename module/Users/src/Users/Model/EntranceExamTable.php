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

class EntranceExamTable
{
    protected $tableGateway;
	protected $select;
	
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	/************* List All Entrance Exams **********/
	public function getEntranceExams(){
		$select = $this->tableGateway->getSql()->select();
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	/************ Country Based Entrance Exams ************/
	public function getBasedOnCountry($countryid){
		$select = $this->tableGateway->getSql()->select();
		$select->where('country_id='.$countryid);
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	public function getEntranceExamsB($searchName){
		$select = $this->tableGateway->getSql()->select();
		$select->where->like( 'entrance_exam_name', $searchName . '%' );
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	public function getEntranceExamIdByName( $entranceExamName )
	{
		$select = $this->tableGateway->getSql()->select();
		$select->where->expression('trim(LOWER(tbl_entrance_exam.entrance_exam_name)) LIKE ?', strtolower($entranceExamName));
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		if($row!=null){
			return $eeid= $row->entrance_exam_id;
		}else{
			return $eeid='';
		}
	}
}