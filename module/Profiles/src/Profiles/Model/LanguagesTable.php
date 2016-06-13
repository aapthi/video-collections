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

class LanguagesTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }		
	public function addUserSkills($us_u_c_id,$user_id)
	{
		$data = array(
			'c_name'  	         => $user_id,
			'c_created_at'       => date('Y-m-d H:i:s'),	
			'c_updated_at'       => date('Y-m-d H:i:s'),
			'c_status'           => 1
		);
		$insertresult=$this->tableGateway->insert($data);
		return $this->tableGateway->lastInsertValue;
	}
	public function delUserSkills($uid){
		$row = $this->tableGateway->delete(array('us_user_id' => $uid));
		return $row;
	}
	public function languagesList()
    {		
		$select = $this->tableGateway->getSql()->select();
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
	public function getUserLang($lan_id)
    {		
		$select = $this->tableGateway->getSql()->select();
		$select->where('lan_id IN('.$lan_id.')');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
}