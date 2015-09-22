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

class CategoryTable
{
    protected $tableGateway;
	protected $select;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }

	public function addUserDetails($user_id)
    {	
		$data = array(
			'user_id' 	     => $user_id, 
			'details_set' 	 => "1", 
			'status' 	     => "1",
			'montage_image'	 => $_SESSION['Zend_Auth']->photoURL
		);	
		
		$this->tableGateway->insert($data);		
		return $this->tableGateway->lastInsertValue;
    }

	public function getAllMenuCategories()
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('tbl_categories.category_type_id=2');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function addCategories($addcatid)
	{
		$data = array(
			'category_name'  		=> $addcatid['catname'],
			'status'          		=> "1",
			'created_at'      		=> date('Y-m-d H:i:s'),
			'category_type_id'  	=> $addcatid['cattypes'],
			'modified_at'  			=> date('Y-m-d H:i:s'),
		);
		$catinserid=$this->tableGateway->insert($data);
		return $catinserid;
	}
	public function getCategoryList()
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('status="1"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function editCategories($editid)
    {
		$selecteditid = $this->tableGateway->getSql()->select();
		$selecteditid->where('category_id="'.$editid.'"');
		$resultSet = $this->tableGateway->selectWith($selecteditid);
		return $resultSet;
	}
	
	public function updatecatid($cat_detailes)
    {	
		$data = array(
			'category_name'  		=> $cat_detailes['catname'],
			'status'          		=> "1",
			'category_type_id'  	=> $cat_detailes['cattypes'],
			'modified_at'  			=> date('Y-m-d H:i:s'),
		);	
		$updaterow=$this->tableGateway->update($data, array('category_id' => $cat_detailes['cat_id']));
		return $updaterow;
	}
	
	public function deleteCategory($deletecatid)
	{
		$result=$this->tableGateway->delete(array('category_id' => $deletecatid));
		 return  $result;
	
	}
	public function getCategories()
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('status=1');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
}