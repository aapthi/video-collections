<?php
namespace ZfcAdmin\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Expression;

class IssuesTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function getIssues()
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('status="1"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function addIssue($issue_data)
    {	
		$data = array(
			'category_id' 	         => $issue_data['category_id'],
			'issue_title' 	         => $issue_data['title'],
			'issue_decription' 	     => $issue_data['article-body'],
			'created_at' 	         => date('Y-m-d H:i:s'),
			'modified_at' 	         => date('Y-m-d H:i:s'),
			'status' 	      		 => 1	,
		);	
		$this->tableGateway->insert($data);		
		return $this->tableGateway->lastInsertValue;
    }
	
	public function addFpNewRow( $userId,$email,$token )
    {	
		$data = array(
			'user_id' 	         => $userId,
			'email' 	         => $email,
			'token' 	         => $token,
			'status' 	         => "0"	,
		);	
		
		$this->tableGateway->insert($data);		
		return $this->tableGateway->lastInsertValue;
    }
	
	public function updateLoginLinkExpired($id)
    {	
		$data = array(
			'status' 	         => "1"
		);	
		$row=$this->tableGateway->update($data, array('user_id' => $id));
		return $row;
	}

	public function checkFpTokenExists( $token )
    {
		$select = $this->tableGateway->getSql()->select();
		$select->where('token="'.$token.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		$row = $resultSet;
		return $row;
	}

	public function deleteToken( $userId )
	{		
		$res=$this->tableGateway->delete( array('user_id' => $userId) );
        return $res;	
	}
	public function deleteIssue( $issue_id )
	{		
		$res=$this->tableGateway->delete( array('issue_id' => $issue_id) );
        return $res;	
	}
	public function getAllMenuIssues( $categoryId )
    {
		if( isset($_SESSION['user']) && isset($_SESSION['user']['user_id']) )
		{
			$userId=$_SESSION['user']['user_id'];
		}
		else
		{
			$userId="";
		}
		$select = $this->tableGateway->getSql()->select();
		$select->join('tbl_categories', 'tbl_issues.category_id=tbl_categories.category_id',array('category_name','category_type_id'),'left');
		$select->join('tbl_likes', new Expression('tbl_likes.issue_id=tbl_issues.issue_id AND tbl_likes.liked_from="'.$userId.'"'),array('like_value'),'left');
		$select->where('tbl_categories.category_type_id=2');
		if( $categoryId > 0 )
		{
			$select->where('tbl_issues.category_id="'.$categoryId.'"');
		}
		$select->order('tbl_issues.modified_at DESC');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function editIssue( $edit_issid )
    {
		$select = $this->tableGateway->getSql()->select();
		$select->join('tbl_categories', 'tbl_issues.category_id=tbl_categories.category_id',array('category_name','category_type_id'),'left');
		$select->where('tbl_issues.issue_id="'.$edit_issid.'"');
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	public function updateIssue($isue_data)
    {	
		$data = array(
			'category_id' 	         => $isue_data['category_id'],
			'issue_title' 	         => $isue_data['title'],
			'issue_decription' 	     => $isue_data['article-body'],
			'modified_at' 	         => date('Y-m-d H:i:s'),
			'status' 	      		 => 1,
		);	
		$update=$this->tableGateway->update($data, array('issue_id' =>$isue_data['issue_id']));
		return $update;
	}
	public function updateTotalLikes($isue_data)
    {	
		$data = array(
			'total_likes' 	         => $isue_data['total_likes'],
			'modified_at' 	         => date('Y-m-d H:i:s'),
		);	
		$update=$this->tableGateway->update($data, array('issue_id' =>$isue_data['issue_id']));
		return $update;
	}
	public function updateTotalShares($isue_data)
    {	
		$data = array(
			'total_shares' 	         => $isue_data['total_shares'],
			'modified_at' 	         => date('Y-m-d H:i:s'),
		);		
		$update=$this->tableGateway->update($data, array('issue_id' =>$isue_data['issue_id']));
		return $update;
	}
	public function getCmsPageHtml( $issueId )
    {
		$select = $this->tableGateway->getSql()->select();
		if( $issueId > 0 )
		{
			$select->where('tbl_issues.issue_id="'.$issueId.'"');
		}
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;

	}

	public function getFooterHtml()
    {
		$footerTitle = "footer";

		$select = $this->tableGateway->getSql()->select();
		$select->where->expression('LOWER(tbl_issues.issue_title) LIKE ?', $footerTitle);
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	
}