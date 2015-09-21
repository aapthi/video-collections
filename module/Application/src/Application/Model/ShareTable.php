<?php
namespace Application\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Expression;

class ShareTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }

	public function addShareMsg($data)
    {	
		$dataa = array(
			'shared_from_email' 	 => $data['fromMail'], 
			'issue_id' 	     => $data['issue_id'],
			'shared_to_email'  => $data['sendMail'],
			'shared_message'  => $data['message'],
			'created_at' 	 => date('Y-m-d'),
			'modified_at' 	 => date('Y-m-d'),
		);	
		$this->tableGateway->insert($dataa);		
		return $this->tableGateway->lastInsertValue;
    }
	public function updateLikedDetails($data,$likeId)
    {	
		$data = array(
			'like_value' 	         => $data['like_type'],
		);	
		$row=$this->tableGateway->update($data, array('liked_id' => $likeId));
		return $row;
	}
}