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

class CollegesTable 
{
    protected $tableGateway;
	protected $select;
	
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function getSchools($countryid,$stateid,$districtid,$keyWord){
		$select = $this->tableGateway->getSql()->select();
		$select->where->like( 'college_name', $keyWord . '%' );
		$select->where('country_id="'.$countryid.'"');
		$select->where('state_id="'.$stateid.'"');
		$select->where('district_id="'.$districtid.'"');
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	/************* List All Colleges **********/
	public function getColleges(){
		$select = $this->tableGateway->getSql()->select();
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	/************ Location Based Colleges **************/
	public function getLocationBasedColleges($countryid,$stateid,$districtid){
		$select = $this->tableGateway->getSql()->select();
		$select->where('country_id="'.$countryid.'"');
		$select->where('state_id="'.$stateid.'"');
		$select->where('district_id="'.$districtid.'"');
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	public function getJCollIdByName( $jCollName )
	{
		$select = $this->tableGateway->getSql()->select();
		$select->where->expression('trim(LOWER(tbl_colleges_junior.college_name)) LIKE ?', trim(strtolower($jCollName)));
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		if($row!=null){
			return $collid = $row->college_id;
		}else{
			return $collid = '';
		}
	}
}