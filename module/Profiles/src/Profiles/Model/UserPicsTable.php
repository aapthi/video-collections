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

class UserPicsTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }	
	public function picList($id)
	{	
		$select = $this->tableGateway->getSql()->select();
		$select->where('vc_user_pics.vp_u_id="'.$id.'"');
		$resultSet = $this->tableGateway->selectWith($select);		
		return $resultSet;
	}
	public function insertImages($u_id,$target_files)
	{
		$data = array(			 		
			'vp_u_id'       => $u_id, 	
			'vp_pics' 	    => $target_files, 	
			'vp_created_at' => date('Y-m-d H:i:s'), 
			'vp_updated_at' => date('Y-m-d H:i:s'),
			'vp_status'		=> 0
		);
		$insertresult=$this->tableGateway->insert($data);		
		return $insertresult;
	}
	public function updateStatus($id,$status){
		$data = array(
			'vp_status'  	=> $status,
			'vp_updated_at'  => date('Y-m-d H:i:s')	
		);
		$updateresult=$this->tableGateway->update($data, array('vp_id' => $id));
		return $updateresult;	
	}
}