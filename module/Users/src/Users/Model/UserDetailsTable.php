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

class UserDetailsTable
{
    protected $tableGateway;
	protected $select;

	 public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
		$this->select = new Select();
    }
	public function addDetails($usersinfo,$user_id,$id_countries_school,$jCollId,$id_countries_bachelors,$id_countries_masters,$id_countries_phd,$entranceExam1,$entranceExam2,$entranceExam3,$b_u,$b_c,$m_u,$m_c,$d_u,$d_c,$b_b){
		if($usersinfo['user_principal_name']!=''){
			$user_principal_name=$usersinfo['user_principal_name'];			
		}else{			
			$user_principal_name='';
		}
		if($usersinfo['user_princi_phone']!=''){
			$user_princi_phone=$usersinfo['user_princi_phone'];			
		}else{			
			$user_princi_phone='';
		}
		if($usersinfo['user_princi_email']!=''){
			$user_princi_email=$usersinfo['user_princi_email'];			
		}else{			
			$user_princi_email='';
		}
// Entrnce 1
		if($usersinfo['user_entrance_year']!=''){
			$user_entrance_year=$usersinfo['user_entrance_year'];			
		}else{			
			$user_entrance_year='';
		}
		if($usersinfo['user_entrance_exam_1']!=''){
			$user_entrance_exam=$usersinfo['user_entrance_exam_1'];			
		}else{			
			$user_entrance_exam='';
		}
		if($usersinfo['user_entrance_rank']!=''){
			$user_entrance_rank=$usersinfo['user_entrance_rank'];			
		}else{			
			$user_entrance_rank='';
		}
// Entrnce 2		
		if($usersinfo['user_entrance_year_1']!=''){
			$user_entrance_year_1=$usersinfo['user_entrance_year_1'];			
		}else{			
			$user_entrance_year_1='';
		}
		if($usersinfo['user_entrance_exam_2']!=''){
			$user_entrance_exam_1=$usersinfo['user_entrance_exam_2'];			
		}else{			
			$user_entrance_exam_1='';
		}
		if($usersinfo['user_entrance_rank_1']!=''){
			$user_entrance_rank_1=$usersinfo['user_entrance_rank_1'];			
		}else{			
			$user_entrance_rank_1='';
		}
// Entrnce 3		
		if($usersinfo['user_entrance_year_2']!=''){
			$user_entrance_year_2=$usersinfo['user_entrance_year_2'];			
		}else{			
			$user_entrance_year_2='';
		}
		if($usersinfo['user_entrance_exam_3']!=''){
			$user_entrance_exam_2=$usersinfo['user_entrance_exam_3'];			
		}else{			
			$user_entrance_exam_2='';
		}
		if($usersinfo['user_entrance_rank_2']!=''){
			$user_entrance_rank_2=$usersinfo['user_entrance_rank_2'];			
		}else{			
			$user_entrance_rank_2='';
		}

		if($usersinfo['user_bac_degree']!=''){
			$user_bac_degree=$usersinfo['user_bac_degree'];			
		}else{			
			$user_bac_degree='';
		}
		if($usersinfo['user_bac_unversity']!=''){
			$user_bac_unversity=$usersinfo['user_bac_unversity'];			
		}else{			
			$user_bac_unversity='';
		}
		if($usersinfo['user_bac_branch']!=''){
			$user_bac_branch=$usersinfo['user_bac_branch'];			
		}else{			
			$user_bac_branch='';
		}
		if($usersinfo['user_bac_college']!=''){
			$user_bac_college=$usersinfo['user_bac_college'];			
		}else{			
			$user_bac_college='';
		}
		if($usersinfo['user_bac_speclization']!=''){
			$user_bac_speclization=$usersinfo['user_bac_speclization'];			
		}else{			
			$user_bac_speclization='';
		}
		if($usersinfo['user_bac_year']!=''){
			$user_bac_year=$usersinfo['user_bac_year'];			
		}else{			
			$user_bac_year='';
		}
		if($usersinfo['user_master_degree']!=''){
			$user_master_degree=$usersinfo['user_master_degree'];			
		}else{			
			$user_master_degree='';
		}
		if($usersinfo['user_mast_university']!=''){
			$user_mast_university=$usersinfo['user_mast_university'];			
		}else{			
			$user_mast_university='';
		}
		if($usersinfo['user_mast_college']!=''){
			$user_mast_college=$usersinfo['user_mast_college'];			
		}else{			
			$user_mast_college='';
		}
		if($usersinfo['user_mast_spec']!=''){
			$user_mast_spec=$usersinfo['user_mast_spec'];			
		}else{			
			$user_mast_spec='';
		}
		if($usersinfo['user_mast_year']!=''){
			$user_mast_year=$usersinfo['user_mast_year'];			
		}else{			
			$user_mast_year='';
		}
		if($usersinfo['user_doctor_phd']!=''){
			$user_doctor_phd=$usersinfo['user_doctor_phd'];			
		}else{			
			$user_doctor_phd='';
		}
		if($usersinfo['user_doctor_university']!=''){
			$user_doctor_university=$usersinfo['user_doctor_university'];			
		}else{			
			$user_doctor_university='';
		}
		if($usersinfo['user_doctor_college']!=''){
			$user_doctor_college=$usersinfo['user_doctor_college'];			
		}else{			
			$user_doctor_college='';
		}
		if($usersinfo['user_doctor_spec']!=''){
			$user_doctor_spec=$usersinfo['user_doctor_spec'];			
		}else{			
			$user_doctor_spec='';
		}
		if($usersinfo['user_doctor_year']!=''){
			$user_doctor_year=$usersinfo['user_doctor_year'];			
		}else{			
			$user_doctor_year='';
		}
		$data = array(
			'user_id' 		            => $user_id,  		
			'id_countries_school'       => $id_countries_school, 	
			'college_name' 		        => $jCollId, 	
			'principal_name'  	        => $user_principal_name,  	
			'principal_phone_num'       => $user_princi_phone,  	
			'principal_email_id'        => $user_princi_email,  
// Entrance 1			
			'entrance_exam'  	        => $entranceExam1,  	
			'which_year'  	            => $user_entrance_year,  	
			'entrance_rank'  	        => $user_entrance_rank, 
// Entrance 2	
			'entrance_exam_1'  	        => $entranceExam2,  	
			'which_year_1'  	        => $user_entrance_year_1,  	
			'entrance_rank_1'  	        => $user_entrance_rank_1, 
// Entrance 3
			'entrance_exam_2'  	        => $entranceExam3,  	
			'which_year_2'  	        => $user_entrance_year_2,  	
			'entrance_rank_2'  	        => $user_entrance_rank_2, 			
			'id_countries_bachelors'    => $id_countries_bachelors,  	
			'bachelors_degree_name'     => $user_bac_degree,  	
			'bachelors_university_name' => $b_u,  	
			'bachelors_college'         => $b_c,  	
			'user_bac_branch'           => $b_b,  	
			'bachelors_specialization'  => $user_bac_speclization,  	
			'bachelors_year_admission'  => $user_bac_year,  	
			'id_countries_masters'      => $id_countries_masters,  	
			'masters_degree'  	        => $user_master_degree,  	
			'masters_university'  	    => $m_u,  	
			'masters_college'           => $m_c,  	
			'masters_specialization'  	=> $user_mast_spec,  	
			'masters_year_admission'  	=> $user_mast_year,
			'id_countries_phd'		  	=> $id_countries_phd,
			'doctorate_name'  	        => $user_doctor_phd,
			'doctorate_college'  	    => $d_c,
			'doctorate_university'  	=> $d_u,
			'doctorate_specialization' 	=> $user_doctor_spec,
			'doctorate_year' 	        => $user_doctor_year,
			'modified_at' 	            => date('Y-m-d H:i:s'),   
		);
		if(isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id']!=""){
			$updateresult=$this->tableGateway->update($data, array('user_id' => $user_id));
			return $updateresult;
		}else{
			$insertresult=$this->tableGateway->insert($data);
			return $this->tableGateway->lastInsertValue;	
		}	
		
	}
	

}