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
	public function addCategories($addcat,$caid)
	{
		if($caid!=''){
			$data = array(
				'category_name'  		=> $addcat['catname'],
				'modified_at'          	=> date('Y-m-d H:i:s')
			);
			$updateresult=$this->tableGateway->update($data, array('category_id' => $caid));
			return $updateresult;
		}else{
			$data = array(
				'category_name'  		=> $addcat['catname'],
				'status'          		=> "1",
				'created_at'          	=> date('Y-m-d H:i:s')
			);
			$insertresult=$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;
		}		
	}
	public function addSubCategory($addsubcat,$pcatid){
		$data = array(
			'category_name'  		=> $addsubcat,
			'parent_cat_id'       	=> $pcatid,
			'status'          		=> "1",
			'created_at'          	=> date('Y-m-d H:i:s'), 
			'modified_at'          	=> date('Y-m-d H:i:s'), 
		);
		$insertresult=$this->tableGateway->insert($data);
		return $this->tableGateway->lastInsertValue;
	}
	public function getCategoryList()
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('vc_categories.parent_cat_id IS NULL');
		$select->where('vc_categories.status="1"');		
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function getCategoryListD()
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('vc_categories.status="1"');		
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function getCategoryListF()
    {
		$select = $this->tableGateway->getSql()->select();
		$select->join(array('subCat' => 'vc_categories'),'subCat.parent_cat_id=vc_categories.category_id',array('subcategory_id' =>new Expression('subCat.category_id'),'subcategory' =>new Expression('subCat.category_name')),'left');
		$select->where('vc_categories.status="1"');		
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function editCategories($editid)
    {
		$select = $this->tableGateway->getSql()->select();
		$select->join(array('subCat' => 'vc_categories'),'subCat.parent_cat_id=vc_categories.category_id',array('subcategory_id' =>new Expression('subCat.category_id'),'subcategory' =>new Expression('subCat.category_name')),'left');
		$select->where('vc_categories.category_id="'.$editid.'"');
		$select->where('vc_categories.status="1"');		
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function cntSubCat($catid){
		$select = $this->tableGateway->getSql()->select();
		$select->where('parent_cat_id ="'.$catid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet->count();
	}
	public function delSubCategories($catid){
		$this->tableGateway->delete(array('(parent_cat_id IN ('.$catid.'))'));			
		return $this->tableGateway->lastInsertValue;	
	}
}