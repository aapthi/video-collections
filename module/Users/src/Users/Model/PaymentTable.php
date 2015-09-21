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

class PaymentTable
{
    protected $tableGateway;
	protected $select;
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }	
	public function addPayment($firstname,$email,$phone,$txnid,$amount,$status)
    {
		$data = array(
			'firstname' 	=> $firstname,  		
			'amount' 		=> $amount, 	
			'txnid'         => $txnid,	
			'emailid'       => $email,	
			'phone_number'  => $phone,	
			'created_at' 	=> date('Y-m-d H:i:s'),   
			'status' 		=> $status,  		
		);
		$insertresult=$this->tableGateway->insert($data);
		return $this->tableGateway->lastInsertValue;					
    }
	public function statusUpdate($status,$txnid){
		$data = array(
			'status' 		=> $status,  		
		);
		$updateresult=$this->tableGateway->update($data, array('txnid' => $txnid));
		return $updateresult;		
	}
}