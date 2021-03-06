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

class UserSkillsTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }		
	public function addUserSkills($us_u_c_id,$u_id)
	{
		$this->delUserSkills($u_id);
		foreach($us_u_c_id['state_id'] as $skill=>$val){	
			$data = array(
				'us_user_id'  	    => $u_id,
				'us_u_c_id'         => $val,
				'us_created_at'     => date('Y-m-d H:i:s'),	
				'us_updated_at'     => date('Y-m-d H:i:s'),
				'us_status'         => 1
			);
			$insertresult=$this->tableGateway->insert($data);		
		}
		return $this->tableGateway->lastInsertValue;
	}
	public function delUserSkills($uid){
		$row = $this->tableGateway->delete(array('us_user_id' => $uid));
		return $row;
	}
	public function skillsList($id)
	{
		$select = $this->tableGateway->getSql()->select();
		$select->join('vc_user_category', 'vc_user_skills.us_u_c_id=vc_user_category.u_c_id',array('*'),'left');
		$select->where('vc_user_skills.us_user_id="'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
	
}