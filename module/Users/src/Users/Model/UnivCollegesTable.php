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

class UnivCollegesTable 
{
    protected $tableGateway;
	protected $select;
	
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function getUnivCollegeIdByName( $univCollegeName )
	{
		$select = $this->tableGateway->getSql()->select();
		$select->where->expression('trim(LOWER(tbl_colleges_univ.univ_college_name)) LIKE ?', trim(strtolower($univCollegeName)));
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		if($row!=null){
			return $ucd = $row->univ_college_id;
		}else{
			return $ucd='';	
		}
	}
	public function getColleges($specId,$countryid,$univId,$keyword){
		$select = $this->tableGateway->getSql()->select();
		$select->where->like( 'univ_college_name', $keyword . '%' );
		$select->where('id_countries="'.$countryid.'"');
		$select->where('specialization_id="'.$specId.'"');
		$select->where('university_id="'.$univId.'"');
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
}