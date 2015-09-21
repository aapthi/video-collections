<?php
namespace Users\Controller;
use Zend\Form\Form;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\Stdlib\Parameters;
use Zend\Authentication\AuthenticationService;
use SanAuthWithDbSaveHandler\Storage\IdentityManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
use Zend\Cache\StorageFactory;
use ScnSocialAuth\Mapper\UserProviderInterface;
class UsersController extends AbstractActionController
{
	protected  $userTable;
	protected  $userDetailsTable;
	protected  $userpersonalinfoTable;
	protected  $countriesinfoTable;
	protected  $userTypeTable;
	protected  $statesTable;
	protected  $districtsTable;
	protected  $collegeTable;
	protected  $entranceexamsTable;
	protected  $specializationsTable;
	protected  $unversitiesTable;
	protected  $forgotPasswordTable;
	protected  $univcollegesTable;
	protected  $branchesTable;
	protected  $paymentsTable;
	public function indexAction()
	{
	}
	public function aboutThePageAction(){
	
	}
	public function onlinePaymentsAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['firstname']) && $_POST['firstname']!=''){
			$firstname=$_POST["firstname"];
			$amount=$_POST["amount"];
			$txnid=$_POST["txnid"];
			$email=$_POST["email"];
			$phone=$_POST["phone"];
			$productinfo="Product Information";
			$key="JBZaLc";
			$salt="GQs7yium";
			$hashSeq=$key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||||||||'.$salt;
			$hash=hash("sha512",$hashSeq);			
			$view=new ViewModel(array(
				'firstname' 		=> 	$firstname,
				'amount' 		    => 	$amount,
				'txnid' 		    => 	$txnid,
				'email' 		    => 	$email,
				'phone' 		    => 	$phone,
				'productinfo' 		=> 	$productinfo,
				'key' 		        => 	$key,
				'salt' 		        => 	$salt,
				'hash' 		        => 	$hash,
				'baseUrl' 			=> $baseUrl,
				'basePath' 			=> $basePath,
			));
			$view->setTerminal(false)
				 ->setTemplate('users/users/payment-summery.phtml');
			return $view;
		}		
	}
	public function addUserPaymentAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['firstname']) && $_POST['firstname']!=''){
			$status='Pending';
			$firstname=$_POST["firstname"];
			$amount=$_POST["amount"];
			$txnid=$_POST["txnid"];
			$email=$_POST["email"];
			$phone=$_POST["phone"];
			$addPayment=$this->getPaymentsTable()->addPayment($firstname,$email,$phone,$txnid,$amount,$status);
			if($addPayment>=0){
				return $view=new JsonModel(array(
					'output' 		        => 	'success',
					'baseUrl' 			=> $baseUrl,
					'basePath' 			=> $basePath
				));
			}
		}		
	}
	public function successPaymentAction(){ 
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['status']) && $_POST['status']!=''){
			$status=$_POST["status"];
			$firstname=$_POST["firstname"];
			$amount=$_POST["amount"];
			$txnid=$_POST["txnid"];
			$posted_hash=$_POST["hash"];
			$key=$_POST["key"];
			$productinfo=$_POST["productinfo"];
			$email=$_POST["email"];
			$salt="GQs7yium";
			$updateStatusPayment=$this->getPaymentsTable()->statusUpdate($status,$txnid);
			if(isset($_POST["additionalCharges"])){
				$additionalCharges=$_POST["additionalCharges"];
				$retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;		
			}else{	  
				$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
			}
			$hash = hash("sha512", $retHashSeq);
				
			if ($hash != $posted_hash) {
			   $errorInvalid = "Invalid Transaction. Please try again";
			   return $result = new ViewModel(array(					
					'output' 		=> 'not-success',
					'errorInvalid'	=>	$errorInvalid,
					'success'		=>	false,
					'baseUrl' 			=> $baseUrl,
					'basePath' 			=> $basePath
				));	
			}else {	
				return $result = new ViewModel(array(					
					'output' 		=> 'success',
					'firstname'		=>	$firstname,
					'status'	    =>	$status,
					'txnid'	        =>	$txnid,
					'amount'	        =>	$amount,
					'success'		=>	true,
					'baseUrl' 			=> $baseUrl,
					'basePath' 			=> $basePath
				));	
			}			
		}		
	}
	public function failurePaymentAction(){ 
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['status']) && $_POST['status']!=''){
			$status=$_POST["status"];
			$firstname=$_POST["firstname"];
			$amount=$_POST["amount"];
			$txnid=$_POST["txnid"];
			$posted_hash=$_POST["hash"];
			$key=$_POST["key"];
			$productinfo=$_POST["productinfo"];
			$email=$_POST["email"];
			$salt="GQs7yium";
			$updateStatusPayment=$this->getPaymentsTable()->statusUpdate($status,$txnid);
			if(isset($_POST["additionalCharges"])){
				$additionalCharges=$_POST["additionalCharges"];
				$retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;		
			}else{	  
				$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
			}
			$hash = hash("sha512", $retHashSeq);
				
			if ($hash != $posted_hash) {
			   $errorInvalid = "Invalid Transaction. Please try again";
			   return $result = new ViewModel(array(					
					'output' 		=> 'not-success',
					'errorInvalid'	=>	$errorInvalid,
					'success'		=>	false,
					'baseUrl' 			=> $baseUrl,
					'basePath' 			=> $basePath
				));	
			}else {	
				return $result = new ViewModel(array(					
					'output' 		=> 'success',
					'firstname'		=>	$firstname,
					'status'	    =>	$status,
					'txnid'	        =>	$txnid,
					'amount'	    =>	$amount,
					'success'		=>	true,
					'baseUrl' 			=> $baseUrl,
					'basePath' 			=> $basePath
				));	
			}			
		}		
	}
	public function viewProfileAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_GET['uid']) && $_GET['uid']!=""){
			$base_user_id = base64_decode($_GET['uid']);
			$getUserDetails = $this->getUserTable()->getUserDetails($base_user_id);			
			if($getUserDetails!=''){
				return new ViewModel(array(				
					'userDetails' 		=> $getUserDetails,
					'baseUrl' 			=> $baseUrl,
					'basePath' 			=> $basePath,
				));		
			}
		}
	}	
	public function registerAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];		
		if(isset($_POST['hid_user_id']) && $_POST['hid_user_id']!=''){	
			$base_user_id =  base64_encode($_POST['hid_user_id']);
			$user_id=$this->getUserTable()->addUser($_POST,$_POST['hid_user_id']);
			$_SESSION['user']['username']=$_POST['user_first_name'];
			$suc = 'udt';
			if($user_id>=0){
				return $this->redirect()->toUrl($baseUrl.'/users/view-profile?uid='.$base_user_id.'&suc='.$suc);
			}
		}else if(isset($_POST['user_first_name']) && $_POST['user_first_name']!='' && isset($_POST['hid_user_id']) && $_POST['hid_user_id']==''){
			$user_id=$this->getUserTable()->addUser($_POST,$_POST['hid_user_id']='');
			if($user_id!=0){
				$usersTable=$this->getUserTable();
				$userDetails = $usersTable->getUser($user_id);
				if($userDetails!=''){						
					$base_user_id =  base64_encode($userDetails->user_id);
					include('public/PHPMailer_5.2.4/sendmail.php');	
					$suc = 'reg';
					global $regSubject;				
					global $regMessage;
					$username = $userDetails->user_name;
					$to=$userDetails->email_id;
					$regMessage = str_replace("<FULLNAME>","$username", $regMessage);
					if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='poraapo.com'){
						$regMessage = str_replace("<ACTIVATIONLINK>","http://" . $_SERVER['HTTP_HOST']."/users/reg-authentication?uid=".$base_user_id, $regMessage);
					}else{
						$regMessage = str_replace("<ACTIVATIONLINK>",$baseUrl."/users/reg-authentication?uid=".$base_user_id, $regMessage);
					}
					if(sendMail($to,$regSubject,$regMessage)){
						if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='poraapo.com'){
							return $this->redirect()->toUrl($baseUrl.'?suc='.$suc);
						}else{
							return $this->redirect()->toUrl($baseUrl.'?suc='.$suc);
						}
					}else{
						return $this->redirect()->toUrl($baseUrl.'?suc='.$suc);
					}							
				}	
			}
		}else if(isset($_GET['uid']) && $_GET['uid']!=""){
			$base_user_id = base64_decode($_GET['uid']);
			$getUserDetails = $this->getUserTable()->getUserDetails($base_user_id);			
			if($getUserDetails!=''){
				return new ViewModel(array(				
					'userDetails' 		=> $getUserDetails,	
					'baseUrl' 			=> $baseUrl,
					'basePath' 			=> $basePath,
				));		
			}
		}else{			
			return new ViewModel(array(				
				'baseUrl' 			=> $baseUrl,
				'basePath' 			=> $basePath,
			));	
		}
	}
	public function regAuthenticationAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$userid=base64_decode($_GET['uid']);		
		$userAuth=$this->getUserTable()->updateUserRegAuth($userid);		
		$userDetails=$this->getUserTable()->checkUserStatus($userid);		
		if($userDetails!=''){
			$to=$userDetails->email_id;
			$userName=ucfirst($userDetails->user_name);
			$user_session = new Container('user');
			$user_session->username=$userDetails->user_name;
			$user_session->email=$userDetails->email_id;
			$user_session->user_id=$userDetails->user_id;
			$user_session->user_type=$userDetails->user_type_id;
			include('public/PHPMailer_5.2.4/sendmail.php');	
			global $completeRegisterSubject;				
			global $completeRegisterMessage;
			$base_user_id=base64_encode($userid);
			$completeRegisterMessage = str_replace("<FULLNAME>",$userName, $completeRegisterMessage);
			if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='poraapo.com'){
				$completeRegisterMessage = str_replace("<ClickeHere>","http://" . $_SERVER['HTTP_HOST'], $completeRegisterMessage);	
			}else{
				$completeRegisterMessage = str_replace("<ClickeHere>",$baseUrl, $completeRegisterMessage);	
			}
			if(sendMail($to,$completeRegisterSubject,$completeRegisterMessage)){		
				return $this->redirect()->toUrl($baseUrl.'/users/view-profile?uid='.$base_user_id);
			}else{
				return $this->redirect()->toUrl($baseUrl.'/users/view-profile?uid='.$base_user_id);
			}
		}
	}
	public function checkEmailExistsAction(){
		if(isset($_POST['user_email']) && $_POST['user_email']!=''){
			$existsEmail=$this->getUserTable()->fpcheckEmail($_POST['user_email']);
			if($existsEmail!=0){
				$result = new JsonModel(array(					
					'output' => 'exists',
					'success'=>true,
				));			
			}else{
				$result = new JsonModel(array(					
					'output' => 'notexists',
					'success'=>false,
				));	
			}
		}
		return $result;
	}
	public function loginAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['inputEmail']) && $_POST['inputEmail']!=""){
			$usersTable=$this->getUserTable();
			$userDetailss = $usersTable->checkEmailExists($_POST);
			if($userDetailss!=''){
				$user_id=$userDetailss->user_id;
				$userDetails = $usersTable->checkUserStatus($user_id);
				if($userDetails!=''){
					$user_session = new Container('user');
					$user_session->username=$userDetails->user_name;
					$user_session->email=$userDetails->email_id;
					$user_session->user_id=$user_id;
					$result = new JsonModel(array(					
						'output' => 'success',
						'user_id' => json_decode($user_id),
					));
				}else{
					 $result = new JsonModel(array(					
						'output' => 'not success',
					));
				}
			}else{
				 $result = new JsonModel(array(					
					'output' => 'not success',
				));
			}
			return $result;
		}	
	}
	public function logoutAction(){	
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		unset($_SESSION['user']);
		return $this->redirect()->toUrl($baseUrl);
	}
	public function changePasswordAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['cnfpwrd'])){
			$usersTable=$this->getUserTable();
			$changepwd = $usersTable->changepwd($_POST['cnfpwrd'],$_POST['userId']);	
			if($changepwd>0){			
				$result = new JsonModel(array(					
					'output' => 'success',
				));			
			}else{
				$result = new JsonModel(array(					
					'output' => 'not success',
				));
			}
			return $result;	
		}		
	
	}
	public function checkPasswordAction(){ 
		$usersTable=$this->getUserTable();
		$pwdExit = $usersTable->getpassword($_POST['oldpasswrd'],$_POST['userId']);		
		if($pwdExit>0){			
			$result = new JsonModel(array(					
				'output' => 'success',
			));			
		}else{
			$result = new JsonModel(array(					
				'output' => 'not success',
			));
		}
		return $result;		
	}	
	public function forgotPasswordAction(){	
	
	}
	public function sendPasswordResetUrlAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
        $baseUrlArr = $baseUrls['urls'];
        $baseUrl = $baseUrlArr['baseUrl'];
		$sentMail=0;
		if(isset($_POST['email']) && $_POST['email']!=""){
			$username=$_POST['email'];
			$usersTable=$this->getUserTable();
			$forgetTable=$this->getForgotPasswordTable();
			$emailCount = $usersTable->checkEmail($_POST['email'])->toArray();
			if(count($emailCount)!=0){
				$user_id=$emailCount[0]['user_id'];
				$token = getUniqueCode('10');
				$mailExit=$forgetTable->getmailfromfgtpwd($_POST['email'])->toArray();
				if(count($mailExit)!=0){
					$alreadyexitid=$mailExit[0]['forget_pwd_id'];
					$getuserId=$forgetTable->updateForgetPassword($alreadyexitid,$token,$user_id);
				}else{
					$alreadyexitid='';
					$getuserId=$forgetTable->addForgetpwd($alreadyexitid,$_POST['email'],$user_id,$token);
				}
				include('public/PHPMailer_5.2.4/sendmail.php');	
				global $forgotPasswordSubject;				
				global $frogotPasswordMessage;
				$frogotPasswordMessage = str_replace("<FULLNAME>",$username, $frogotPasswordMessage);
				$frogotPasswordMessage = str_replace("<PASSWORDLINK>",$baseUrl."/users/reset-password?token=".$token, $frogotPasswordMessage);	
				$to=$_POST['email'];
				if(sendMail($to,$forgotPasswordSubject,$frogotPasswordMessage)){
						$result = new JsonModel(array(					
							'output' => 'success',
							'success'=>true,
						));	
				}else{
					 $result = new JsonModel(array(					
					'output' 	=> 'notsuccess',
					));
				}
			}else{
				$result = new JsonModel(array(					
					'output' 	=> 'Not Found The Email',
				));
			}
			return $result;
		}		
	}
	public function resetPasswordAction(){
		$token=$_GET['token'];
		$tokeninfo=array();
		$exitToke=0;
		$forgetTable=$this->getForgotPasswordTable();
		$tokenExit=$forgetTable->gettoken($token)->toArray();	
		if(count($tokenExit)!=0){				
			$result = new ViewModel(array(					
				'output' => 'success',
				'existtoken' =>'1'
			));			
		}else{
			$result = new ViewModel(array(					
				'output' => 'not success',
				'existtoken' =>'0'
			));
		}
		return $result;		
	}
	public function setnepasswordAction(){
		if(isset($_POST['token']) && $_POST['token']!=""){
			$token=$_POST['token'];		
			$tokeninfo=array();
			$forgetTable=$this->getForgotPasswordTable();
			$usersTable=$this->getUserTable();
			$tokenExit=$forgetTable->gettoken($token);
			foreach($tokenExit as $tokeninfo){}
			if($tokeninfo->user_id>0){
				$changepwd = $usersTable->changepwd($_POST['cnfpwrd'],$tokeninfo->user_id);	
				if($changepwd>=0){
					$deletetokenid=$forgetTable->deletetoken($tokeninfo->forget_pwd_id);
					$result = new JsonModel(array(					
						'output' => 'success',
						'success'=>false,
					));			
				}else{
					$result = new JsonModel(array(					
						'output' => 'not success',
						'not success'=>false,
					));
				}				
			}else{
				$result = new JsonModel(array(					
					'output' => 'not success',
					'not success'=>false,
				));	
			}
			return $result;	
		}
	}	
	public function contactUsAction(){
		if(isset($_POST['contactEmail']) && $_POST['contactEmail']!=""){
			$baseUrls = $this->getServiceLocator()->get('config');
			$baseUrlArr = $baseUrls['urls'];
			$baseUrl = $baseUrlArr['baseUrl'];
			include('public/PHPMailer_5.2.4/sendmail.php');	
			global $contactSubject;				
			global $contactMessage;
			$contactMessage = str_replace("<FIRSTNAME>",$_POST['firstName'], $contactMessage);
			$contactMessage = str_replace("<CONTACTEMAIL>",$_POST['contactEmail'], $contactMessage);
			$contactMessage = str_replace("<LASTNAME>",$_POST['lastName'], $contactMessage);
			$contactMessage = str_replace("<PHONENUMBER>",$_POST['mobileNumber'], $contactMessage);
			$contactMessage = str_replace("<CONTACTMESSAGE>",$_POST['contactMessage'], $contactMessage);
			$to='krishna@poraapo.org';
			if(sendMail($to,$contactSubject,$contactMessage)){
					$result = new ViewModel(array(					
						'output' 	=> 'success',
					));	
			}else{
				   $result = new ViewModel(array(					
						'output' 	=> 'notsuccess',
				   ));
			}
			return $result;
		}
	}
	public function searchCountryNamesAction(){
		$list_countries='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		if(isset($_POST['value']) && $_POST['value']!=""){
			$getCountries=$this->getCountriesTable()->searchCountry($_POST['value']);
			foreach($getCountries as $key=>$search){
				$list_countries[$key]=$search->name;
				$hashNameIds[$key]=$key;
				$count=$key;				
			}
			$combined = array();
			if($list_countries!=''){				
				foreach($list_countries as $index => $refNumber) {			
					$combined[] = array(
						'ref'  => $refNumber,
						'part' => $hashNameIds[$index]
					);
				}
			}$result = new JsonModel(array(					
				'searchHashNames' => $combined,
				'success'=>true,
			));			
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
		}
		return $result;
	}
	public function searchCountryNamesJobsAction(){
		$list_countries='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		if(isset($_POST['value']) && $_POST['value']!=""){
			$getCountries=$this->getCountriesTable()->searchCountry($_POST['value']);
			foreach($getCountries as $key=>$search){
				$list_countries[$key]=$search->name;
				$hashNameIds[$key]=$key;
				$count=$key;				
			}
			$combined = array();
			if($list_countries!=''){				
				foreach($list_countries as $index => $refNumber) {			
					$combined[] = array(
						'ref'  => $refNumber,
						'part' => $hashNameIds[$index]
					);
				}
			}
			$result = new JsonModel(array(					
				'searchHashNames' => $combined,
				'success'=>true,
			));			
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
		}
		return $result;
	}
	public function getStatesAction(){
		$list_countries='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		if(isset($_POST['value']) && $_POST['value']!=''){
			$countryDetails=$this->getCountriesTable()->getCountryIdByName($_POST['country_name']);
			if(count($countryDetails)!=''){
				$country_id = $countryDetails->current()->id_countries;
				$states=$this->getSatesTable()->getStates($country_id,$_POST['value']);
				foreach($states as $key=>$search){
					$list_countries[$key]=$search->state_name;
					$hashNameIds[$key]=$key;
					$count=$key;				
				}
				$combined = array();
				if($list_countries!=''){				
					foreach($list_countries as $index => $refNumber) {			
						$combined[] = array(
							'ref'  => $refNumber,
							'part' => $hashNameIds[$index]
						);
					}
				}
			}
			$result = new JsonModel(array(					
				'searchHashNames' => $combined,
				'success'=>true,
			));			
			return $result;
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
			return $result;
		}
	}
	public function getDistrictsAction(){
		$list_countries='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		if(isset($_POST['state_name']) && $_POST['state_name']!=''){
			if(isset($_POST['value']) && $_POST['value']!=''){
				$states=$this->getSatesTable()->getStateIdByName($_POST['state_name']);
				if($states->state_id!=''){
					$getDistricts=$this->getDistrictsTable()->getDistrictsStates($states->state_id,$_POST['value']);
					foreach($getDistricts as $key=>$search){
						$list_countries[$key]=$search->district_name;
						$hashNameIds[$key]=$key;
						$count=$key;				
					}
					$combined = array();
					if($list_countries!=''){				
						foreach($list_countries as $index => $refNumber) {			
							$combined[] = array(
								'ref'  => $refNumber,
								'part' => $hashNameIds[$index]
							);
						}
					}
					$result = new JsonModel(array(					
						'searchHashNames' => $combined,
						'success'=>true,
					));			
					return $result;
				}
			}else{
				$result = new JsonModel(array(					
					'searchHashNames' => [],
					'success'=>true,
				));			
				return $result;
			}
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
			return $result;
		}
	}
	public function getSchoolsAction(){
		$list_countries='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		$combined = array();
		if(isset($_POST['dist_name']) && $_POST['dist_name']!=""){ 
			if(isset($_POST['value']) && $_POST['value']!=""){ 
				$countryDetails=$this->getCountriesTable()->getCountryIdByName($_POST['country_name']);
				if(count($countryDetails)!=''){ 
					$country_id = $countryDetails->current()->id_countries;
					$states=$this->getSatesTable()->getStateIdByName($_POST['state_name']);
					$stateId = $states->state_id;
					if($stateId!=''){
						$districtId=$this->getDistrictsTable()->getDistrictIdByName($_POST['dist_name']);
						if($districtId!=''){
							$getColleges=$this->getCollegeTable()->getSchools($country_id,$stateId,$districtId,$_POST['value']);
							if(count($getColleges)!=""){
								foreach($getColleges as $key=>$search){
									$list_countries[$key]=$search->college_name;
									$hashNameIds[$key]=$key;
									$count=$key;				
								}
								if($list_countries!=''){				
									foreach($list_countries as $index => $refNumber) {			
										$combined[] = array(
											'ref'  => $refNumber,
											'part' => $hashNameIds[$index]
										);
									}
								}
							}
							$result = new JsonModel(array(					
								'searchHashNames' => $combined,
								'success'=>true,
							));			
							return $result;
						}
					}
				}
			}else{
				$result = new JsonModel(array(					
					'searchHashNames' => [],
					'success'=>true,
				));			
				return $result;
			}
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
			return $result;
		}
	}
	public function getBachelorsUniversityAction(){
		$list_countries='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		if(isset($_POST['spec_id']) && $_POST['spec_id']!=''){
			if(isset($_POST['value']) && $_POST['value']!=''){
				$countryDetails=$this->getCountriesTable()->getCountryIdByName($_POST['country_name']);
				if(count($countryDetails)!=''){ 
					$country_id = $countryDetails->current()->id_countries;
					$getUnversities=$this->getUnversitiesTable()->getUniversities($_POST['spec_id'],$country_id,$_POST['value']);				
					foreach($getUnversities as $key=>$search){
						$list_countries[$key]=$search->unversity_name;
						$hashNameIds[$key]=$key;
						$count=$key;				
					}
					$combined = array();
					if($list_countries!=''){				
						foreach($list_countries as $index => $refNumber) {			
							$combined[] = array(
								'ref'  => $refNumber,
								'part' => $hashNameIds[$index]
							);
						}
					}
					$result = new JsonModel(array(					
						'searchHashNames' => $combined,
						'success'=>true,
					));			
					return $result;
				}
			}else{
				$result = new JsonModel(array(					
					'searchHashNames' => [],
					'success'=>true,
				));			
				return $result;
			}	
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
			return $result;
		}
	}
	public function getBachelorsCollegesAction(){
		$list_countries='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		if(isset($_POST['univ_name']) && $_POST['univ_name']!=''){
			if(isset($_POST['value']) && $_POST['value']!=''){
				$countryDetails=$this->getCountriesTable()->getCountryIdByName($_POST['country_name']);
				if(count($countryDetails)!=''){ 
					$country_id = $countryDetails->current()->id_countries;
					$univId=$this->getUnversitiesTable()->getUniversityIdByName($_POST['univ_name']);	
					if($univId!=''){				
						$getColleges = $this->getUnivCollegesTable()->getColleges($_POST['spec_id'],$country_id,$univId,$_POST['value']);
						foreach($getColleges as $key=>$search){
							$list_countries[$key]=$search->univ_college_name;
							$hashNameIds[$key]=$key;
							$count=$key;				
						}
						$combined = array();
						if($list_countries!=''){				
							foreach($list_countries as $index => $refNumber) {			
								$combined[] = array(
									'ref'  => $refNumber,
									'part' => $hashNameIds[$index]
								);
							}
						}
						$result = new JsonModel(array(					
							'searchHashNames' => $combined,
							'success'=>true,
						));			
						return $result;
					}
				}
			}else{
				$result = new JsonModel(array(					
					'searchHashNames' => [],
					'success'=>true,
				));			
				return $result;
			}
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
			return $result;
		}
	}
	public function getEntranceExamsAction(){
		$list_exams='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		if(isset($_POST['value']) && $_POST['value']!=''){					
			$getEntranceExams = $this->getEntranceExamsTable()->getEntranceExamsB($_POST['value']);
			foreach($getEntranceExams as $key=>$search){
				$list_exams[$key]=$search->entrance_exam_name;
				$hashNameIds[$key]=$key;
				$count=$key;				
			}
			$combined = array();
			if($list_exams!=''){				
				foreach($list_exams as $index => $refNumber) {			
					$combined[] = array(
						'ref'  => $refNumber,
						'part' => $hashNameIds[$index]
					);
				}
			}
			$result = new JsonModel(array(					
				'searchHashNames' => $combined,
				'success'=>true,
			));			
			return $result;
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
			return $result;
		}
	}
	public function getBranchesAction(){
		$list_branch='';
		$hashNames="";
		$hashNameIds="";
		$count="";
		if(isset($_POST['value']) && $_POST['value']!=''){					
			$getBranches = $this->getBranchesTable()->getBranches($_POST['value']);
			foreach($getBranches as $key=>$search){
				$list_branch[$key]=$search->branch_name;
				$hashNameIds[$key]=$key;
				$count=$key;				
			}
			$combined = array();
			if($list_branch!=''){				
				foreach($list_branch as $index => $refNumber) {			
					$combined[] = array(
						'ref'  => $refNumber,
						'part' => $hashNameIds[$index]
					);
				}
			}
			$result = new JsonModel(array(					
				'searchHashNames' => $combined,
				'success'=>true,
			));			
			return $result;
		}else{
			$result = new JsonModel(array(					
				'searchHashNames' => [],
				'success'=>true,
			));			
			return $result;
		}
	
	}
	public function crontosendmailsAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$providerUsers = $this->getUserTable()->getProviderUsers();	
		$listOfUsers = '';	
		$id = array();
		include('public/PHPMailer_5.2.4/sendmail.php');	
		global $activeUserSubject;				
		global $activeUsersMessage;
		if(count($providerUsers)!=""){
			foreach($providerUsers as $users){
				$listOfUsers = $users;
			}
			$user_id = $listOfUsers->user_id;
			$pwd = getUniqueCode('7');
			$updateresult = $this->getUserTable()->toInsertPassword($user_id,$pwd);	
			$base_user_id = base64_encode($user_id);
			if($listOfUsers->user_name!=""){
				$username = $listOfUsers->user_name;
			}else{
				$username = 'New User';
			}
			$emailId = $listOfUsers->email_id;
			$to = $listOfUsers->email_id;
			$password = $pwd;
			$activeUsersMessage = str_replace("<FULLNAME>","$username", $activeUsersMessage);
			if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='poraapo.com'){
				$activeUsersMessage = str_replace("<ACTIVATIONLINK>","http://" . $_SERVER['HTTP_HOST']."/users/reg-authentication?uid=".$base_user_id, $activeUsersMessage);
				$activeUsersMessage = str_replace("<EMAILID>","$emailId", $activeUsersMessage);
				$activeUsersMessage = str_replace("<PASSWORD>","$password", $activeUsersMessage);
			}else{
				$activeUsersMessage = str_replace("<ACTIVATIONLINK>",$baseUrl."/users/reg-authentication?uid=".$base_user_id, $activeUsersMessage);
				$activeUsersMessage = str_replace("<EMAILID>","$emailId", $activeUsersMessage);
				$activeUsersMessage = str_replace("<PASSWORD>","$password", $activeUsersMessage);
			}	
			if(sendMail($to,$activeUserSubject,$activeUsersMessage))
			{
				$id[] = $user_id;
			}	
			if(count($id)){
				$update_status = $this->getUserTable()->sentMailToProvUsers($id);	
			}
			echo "SuccessFull Sent....";exit;
		}else{
			echo "Thanks"; exit;
		}
	}
	public function providerUsersAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$view= new ViewModel(array(
			'basePath'=>$basePath,
		));
		return $view;
	}
	public function getProviderUsersAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_GET['uid']) && $_GET['uid']!=''){
			$providerUsers = $this->getUserTable()->providerUsers($_GET['uid']);
			$data = array();
			$i=0;
			if(isset($providerUsers) && $providerUsers->count()!=0){
			 $catTypeName="";
				foreach($providerUsers as $key=>$users){
					$id=$users->user_id;
					if($users->last_name!=""){
						$last_name = $users->last_name;
					}else{
						$last_name ='';
					}
					$data[$i]['sno']= $i+1;
					$data[$i]['user_name']= $users->user_name;
					$data[$i]['last_name']= $last_name;
					$data[$i]['user_email']= $users->email_id;
					$data[$i]['action'] ='#';
					$i++;
				}
				$data['aaData'] = $data;
				echo json_encode($data['aaData']); exit;
			}else{
				echo '1'; exit;
			}	
		}else{
			echo '1'; exit;
		}		
	}
	//public function headerAction view  header page returns view part
	public function getUnivCollegesTable()
    {
        if (!$this->univcollegesTable) {				
            $sm = $this->getServiceLocator();
            $this->univcollegesTable = $sm->get('Users\Model\UnivCollegesFactory');			
        }
        return $this->univcollegesTable;
    }
	public function getUserTable()
    {
        if (!$this->userTable) {				
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Users\Model\UserTableFactory');			
        }
        return $this->userTable;
    }
	public function getForgotPasswordTable()
    {
        if (!$this->forgotPasswordTable) {				
            $sm = $this->getServiceLocator();
            $this->forgotPasswordTable = $sm->get('Users\Model\ForgotPasswordFactory');			
        }
        return $this->forgotPasswordTable;
    }
	public function getUserPersonalInfoTable()
    {
        if (!$this->userpersonalinfoTable) {				
            $sm = $this->getServiceLocator();
            $this->userpersonalinfoTable = $sm->get('Users\Model\UserPersonalInfoFactory');			
        }
        return $this->userpersonalinfoTable;
    }
	public function getUserDetailsTable()
    {
        if (!$this->userDetailsTable) {				
            $sm = $this->getServiceLocator();
            $this->userDetailsTable = $sm->get('Users\Model\UserDetailsFactory');			
        }
        return $this->userDetailsTable;
    }
	public function getUserTypeTable()
    {
        if (!$this->userTypeTable) {		
            $sm = $this->getServiceLocator();
            $this->userTypeTable = $sm->get('Users\Model\UserTypeFactory');			
        }
        return $this->userTypeTable;
    }
	public function getCountriesTable()
    {
        if (!$this->countriesinfoTable) {		
            $sm = $this->getServiceLocator();
            $this->countriesinfoTable = $sm->get('Users\Model\CountriesFactory');			
        }
        return $this->countriesinfoTable;
    }
	public function getSatesTable()
    {
        if (!$this->statesTable) {		
            $sm = $this->getServiceLocator();
            $this->statesTable = $sm->get('Users\Model\StatesFactory');			
        }
        return $this->statesTable;
    }
	public function getDistrictsTable()
    {
        if (!$this->districtsTable) {		
            $sm = $this->getServiceLocator();
            $this->districtsTable = $sm->get('Users\Model\DistrictsFactory');			
        }
        return $this->districtsTable;
    }
	public function getCollegeTable()
    {
        if (!$this->collegeTable) {		
            $sm = $this->getServiceLocator();
            $this->collegeTable = $sm->get('Users\Model\CollegesFactory');			
        }
        return $this->collegeTable;
    }
	public function getEntranceExamsTable()
    {
        if (!$this->entranceexamsTable) {		
            $sm = $this->getServiceLocator();
            $this->entranceexamsTable = $sm->get('Users\Model\EntranceExamFactory');			
        }
        return $this->entranceexamsTable;
    }
	public function getSpecializationsTable()
    {
        if (!$this->specializationsTable) {		
            $sm = $this->getServiceLocator();
            $this->specializationsTable = $sm->get('Users\Model\SpecializationFactory');			
        }
        return $this->specializationsTable;
    }	
	public function getUnversitiesTable()
    {
        if (!$this->unversitiesTable) {		
            $sm = $this->getServiceLocator();
            $this->unversitiesTable = $sm->get('Users\Model\UniversitiesFactory');			
        }
        return $this->unversitiesTable;
    }
	public function getBranchesTable()
    {
        if (!$this->branchesTable) {		
            $sm = $this->getServiceLocator();
            $this->branchesTable = $sm->get('Users\Model\BranchesFactory');			
        }
        return $this->branchesTable;
    }
	public function getPaymentsTable()
    {
        if (!$this->paymentsTable) {		
            $sm = $this->getServiceLocator();
            $this->paymentsTable = $sm->get('Users\Model\PaymentFactory');			
        }
        return $this->paymentsTable;
    }
}