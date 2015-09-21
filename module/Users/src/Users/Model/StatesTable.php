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

class StatesTable
{
    protected $tableGateway;
	protected $select;

	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	/************* List All States **********/
	public function getSates(){
		$select = $this->tableGateway->getSql()->select();
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	/************** Based on Country *********/
	public function getBasedcountry($countryid){
		$select = $this->tableGateway->getSql()->select();
		$select->where('id_countries="'.$countryid.'"');
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	public function getStates($countryid,$keyWord){
		$select = $this->tableGateway->getSql()->select();
		$select->where->like( 'state_name', $keyWord . '%' );
		$select->where('id_countries="'.$countryid.'"');
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	public function getStateIdByName( $stateName )
	{
		$select = $this->tableGateway->getSql()->select();
		$select->where->expression('trim(LOWER(tbl_states.state_name)) LIKE ?', trim(strtolower($stateName)));
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet->current();
		if($row!=null){
			return $row;
		}else{
			return $row='';	
		}
	}
}