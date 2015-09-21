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

class CountriesTable
{
    protected $tableGateway;
	protected $select;
	
	public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	/************* List All Countries **********/
	public function getCountries(){
		$select = $this->tableGateway->getSql()->select();
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	public function searchCountry($searchName){
		$select = $this->tableGateway->getSql()->select();
		$select->where->like( 'name', $searchName . '%' );
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
	public function getCountryIdByName( $countryName )
	{
		$select = $this->tableGateway->getSql()->select();
		$select->where->expression('trim(LOWER(tbl_countries.name)) LIKE ?', strtolower($countryName));
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}
}