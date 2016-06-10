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
use ScnSocialAuth\Mapper\Exception as MapperException;
use ScnSocialAuth\Mapper\UserProviderInterface;
use ScnSocialAuth\Options\ModuleOptions;
class UsersController extends AbstractActionController
{
	protected  $userTable;
	protected  $userDetailsTable;
	protected  $forgotPasswordTable;
	protected  $paymentsTable;
	protected  $categoriesTable;
	protected  $videoTable;
	
	/**
     * @var UserProviderInterface
     */
    protected $mapper;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /*
     * @todo Make this dynamic / translation-friendly
     * @var string
     */  

	public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;

        return $this;
    }
	
	public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceLocator()->get('ScnSocialAuth-ModuleOptions'));
        }
        return $this->options;
    }
	public function indexAction()
	{
	}
	public function captchaGetcodeAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$returnCode = getUniqueCode(5);
		$result = new JsonModel(array(					
			'captchcode' => $returnCode,
			'success'=>true,
		));	
		return $result;
	}
	function getUniqueCode($length = "")
	{
		$code = md5(uniqid(rand(), true));
		if ($length != "")
		return substr($code, 0, $length);
		else
		return $code;
	}	
	public function videosListAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];		
	}
	public function checkVideoExistsAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];		
		if(isset($_POST['videoLink']) && $_POST['videoLink']!=""){
			$s=$_POST['videoLink'];			
			$link=explode("/", $s);
			$url=$link['2'];			
			$urlName=explode(".", $url);
			if(isset($urlName)){
				if((isset($urlName['1'])) && ($urlName['1']=='youtube')){
					$video_url=$urlName['1'];
					$image=explode("=", $link['3']);
					$imageCode=$image['1'];
					$imageUrl="http://i.ytimg.com/vi/".$imageCode."/default.jpg";
				}else if(isset($urlName['1']) && $urlName['1']=='dailymotion'){
					$video_url=$urlName['1'];
					$image=explode("_", $link['4']);
					$imageCode=$image['0'];
					$imageUrl="http://www.dailymotion.com/thumbnail/video/".$imageCode;
				}else if(isset($urlName['0']) && ($urlName['0']=='vimeo')){
					$video_url= $urlName['0'];
					$imageCode = $link['5'];
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imageCode.php"));
					$imageUrl=$hash[0]['thumbnail_medium'];
				}else{
					$video_url= '';
					$imageUrl= '';
				}
			}
			$existsVideo=$this->getVideoTable()->checkvideoLink($imageCode);
			if($existsVideo!=0){
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
	public function deleteVideoAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_GET['vid']) && $_GET['vid']!=""){
			if( $_GET['st'] == 'd'){
				$userInfo['status']=0;
			}else{
				$userInfo['status']=1;
			}
			$userInfo['vid'] = $_GET['vid'];
			$chgStatus = $this->getVideoTable()->changeAccountStatus($userInfo);
			if($chgStatus>0){
				return $this->redirect()->toUrl($baseUrl.'/users/videos-list');
			}
		}
	}
	public function videoAjaxAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$data = array();
		$i=0;
		$userid = $_SESSION['user']['user_id'];
		$videoTable=$this->getVideoTable();
		$videoData = $videoTable->userVideosList($userid);		
		if(isset($videoData) && $videoData->count()!=0){
		 $catTypeName="";
			foreach($videoData as $video){
				$id=$video->v_id;
				$data[$i]['v_id']=$i+1;
				$data[$i]['cat_name']= $video->category_name;
				$data[$i]['videotitle']= $video->v_title;
				$data[$i]['videolink']= $video->v_link;
				if($video->v_state==1){
					$status = 'Activate';
					$st = 'd';
				}else{
					$status = 'Deactivate';
					$st = 'a';
				}
				$data[$i]['status']= $status;
				// $data[$i]['action'] ='<a href="'.$baseUrl.'/users/video-link?vid='.$id.'">Edit</a>';
				$i++;
			}
			$data['aaData'] = $data;
			echo json_encode($data['aaData']); exit;
		}else{
			echo '1'; exit;
		}
	}
	public function videoLinkAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$userid = $_SESSION['user']['user_id'];
//	Update	
		if(isset($_POST['hid_vid']) && $_POST['hid_vid']!=""){	
			// if(isset($_FILES['video_img']['name']) && $_FILES['video_img']['name']=="" && $_POST['hid_imag']!=""){
				// $image_v = $_POST['hid_imag'];
			// }else if(isset($_POST['hid_imag']) && $_POST['hid_imag']!='' && $_FILES['video_img']['name']!=""){
				// $image_v = $_FILES['video_img']['name'];
			// }
			$image_v ='';
			$s=$_POST['video_link'];			
			$link=explode("/", $s);
			$url=$link['2'];
			$urlName=explode(".", $url);
			if(isset($urlName)){
				if((isset($urlName['1'])) && ($urlName['1']=='youtube')){
					$video_url=$urlName['1'];
					$image=explode("=", $link['3']);
					$imageCode=$image['1'];					
					$imageUrl="http://i.ytimg.com/vi/".$imageCode."/default.jpg";
				}else if(isset($urlName['1']) && $urlName['1']=='dailymotion'){
					$video_url=$urlName['1'];
					$image=explode("_", $link['4']);
					$imageCode=$image['0'];
					$imageUrl="http://www.dailymotion.com/thumbnail/video/".$imageCode;
				}else if(isset($urlName['0']) && ($urlName['0']=='vimeo')){
					$video_url= $urlName['0'];
					$imageCode = $link['5'];
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imageCode.php"));
					$imageUrl=$hash[0]['thumbnail_medium'];
				}else{
					$video_url= '';
					$imageUrl= '';
				}
			}			
			$updatData = $this->getVideoTable()->addVideo($_POST,$video_url,$imageUrl,$imageCode,$userid,$image_v,$_POST['hid_vid']);
			if($updatData>=0){
				include('public/PHPMailer_5.2.4/sendmail.php');	
				global $videolinkSubject;				
				global $videolinkMessage;
				$userDetails=$this->getUserTable()->checkUserStatus($userid);		
				$to=$userDetails->email;
				$userName = ucfirst($userDetails->username);	
				$messageText = 'Successfully updated your video link. Please wait for approval of this video link.'; 
				$videolinkMessage = str_replace("<FULLNAME>",$userName, $videolinkMessage);				
				$videolinkMessage = str_replace("<MESSAGE>",$messageText, $videolinkMessage);				
				if(sendMail($to,$videolinkSubject,$videolinkMessage)){		
					return $this->redirect()->toUrl('videos-list');
				}else{
					return $this->redirect()->toUrl('videos-list');
				}
				// $path = "./public/uploads/".$_POST['hid_vid'];
				// $path2 = $path.'/videoimages';
				// $path3 = $path.'/videoimages/';				
				// move_uploaded_file($_FILES['video_img']['tmp_name'],$path3.$image_v);				
			}
//  Insert
		}else if(isset($_POST['video_title']) && $_POST['video_title']!="" && $_POST['hid_vid']==""){
			$s=$_POST['video_link'];
			$link=explode("/", $s);
			$url=$link['2'];
			$urlName=explode(".", $url);
			if(isset($urlName)){
				if((isset($urlName['1'])) && ($urlName['1']=='youtube')){
					$video_url=$urlName['1'];
					$image=explode("=", $link['3']);
					$imageCode=$image['1'];
					$imageUrl="http://i.ytimg.com/vi/".$imageCode."/default.jpg";
				}else if(isset($urlName['1']) && $urlName['1']=='dailymotion'){
					$video_url=$urlName['1'];
					$image=explode("_", $link['4']);
					$imageCode=$image['0'];
					$imageUrl="http://www.dailymotion.com/thumbnail/video/".$imageCode;
				}else if(isset($urlName['0']) && ($urlName['0']=='vimeo')){
					$video_url= $urlName['0'];
					$imageCode = $link['5'];
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imageCode.php"));
					$imageUrl=$hash[0]['thumbnail_medium'];
				}else{
					$video_url= '';
					$imageUrl= '';
				}
			}
			$videoTable=$this->getVideoTable();			
			$insertVid = $videoTable->addVideo($_POST,$video_url,$imageUrl,$imageCode,$userid,$image_v ='',$_POST['hid_vid']);
			if($insertVid>0){
				// $path = "./public/uploads/".$insertVid;
				// mkdir($path);
				// $path2 = $path.'/videoimages/';
				// mkdir($path2);	
				// move_uploaded_file($_FILES['video_img']['tmp_name'],$path2.$_FILES['video_img']['name']);
				include('public/PHPMailer_5.2.4/sendmail.php');	
				global $videolinkSubject;				
				global $videolinkMessage;
				$userDetails=$this->getUserTable()->checkUserStatus($userid);		
				$to=$userDetails->email;
				$userName = ucfirst($userDetails->username);	
				$messageText = 'Successfully added your video link. Please wait for approval of this video link.'; 
				$videolinkMessage = str_replace("<FULLNAME>",$userName, $videolinkMessage);				
				$videolinkMessage = str_replace("<MESSAGE>",$messageText, $videolinkMessage);				
				if(sendMail($to,$videolinkSubject,$videolinkMessage)){		
					return $this->redirect()->toUrl('videos-list');
				}else{
					return $this->redirect()->toUrl('videos-list');
				}
			}
//  Get
		}else if(isset($_GET['vid']) && $_GET['vid']!=""){
			$catList = $this->getCategoryTable()->getCategoryListD();
			$videoInfo=$this->getVideoTable()->getVideoInfo($_GET['vid']);
			return new ViewModel(array(
				'catData'	  =>  $catList,
				'videoInfo'	  =>  $videoInfo,
				'basePath'	  =>  $basePath,	
				'baseUrl'	  =>  $baseUrl	
			));
		}else{
			$catList = $this->getCategoryTable()->getCategoryListD();
			return new ViewModel(array(
				'catData'	  =>  $catList,
				'basePath'	  =>  $basePath,	
				'baseUrl'	  =>  $baseUrl	
			));
		}
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
				$user_idd=$this->getUserDetailsTable()->addDetails($_POST,$_POST['hid_user_id'],$_POST['hid_ud_id']);
				return $this->redirect()->toUrl($baseUrl.'/users/view-profile?uid='.$base_user_id.'&suc='.$suc);
			}
		}else if(isset($_POST['user_first_name']) && $_POST['user_first_name']!='' && isset($_POST['hid_user_id']) && $_POST['hid_user_id']==''){
			$user_id=$this->getUserTable()->addUser($_POST,$_POST['hid_user_id']='');
			if($user_id!=0){
				$user_idd=$this->getUserDetailsTable()->addDetails($_POST,$user_id,$_POST['hid_ud_id']);
				$usersTable=$this->getUserTable();
				$userDetails = $usersTable->getUser($user_id);
				if($userDetails!=''){						
					$base_user_id =  base64_encode($userDetails->user_id);
					include('public/PHPMailer_5.2.4/sendmail.php');	
					$suc = 'reg';
					global $regSubject;				
					global $regMessage;
					$username = $userDetails->username;
					$to=$userDetails->email;
					$regMessage = str_replace("<FULLNAME>","$username", $regMessage);
					if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='mathassess.com'){
						$regMessage = str_replace("<ACTIVATIONLINK>",$baseUrl."/users/reg-authentication?uid=".$base_user_id, $regMessage);
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
			$to=$userDetails->email;
			$userName=ucfirst($userDetails->username);
			$user_session = new Container('user');
			$user_session->username=$userDetails->username;
			$user_session->email=$userDetails->email;
			$user_session->user_id=$userDetails->user_id;
			include('public/PHPMailer_5.2.4/sendmail.php');	
			global $completeRegisterSubject;				
			global $completeRegisterMessage;
			$base_user_id=base64_encode($userid);
			$completeRegisterMessage = str_replace("<FULLNAME>",$userName, $completeRegisterMessage);
			if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']=='mathassess.com'){
				$completeRegisterMessage = str_replace("<ClickeHere>",$baseUrl, $completeRegisterMessage);	
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
					$user_session->username=$userDetails->username;
					$user_session->displayName=$userDetails->display_name;
					$user_session->email=$userDetails->email;
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
		}else{
			return new ViewModel(array(				
				'baseUrl' 			=> $baseUrl,
				'basePath' 			=> $basePath,
				'options'			=>	$this->getOptions()
			));				
		}	
	}
	public function logoutAction(){	
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		foreach($_SESSION as $key => $val)
		{
			 unset($_SESSION[$key]);
		}
		session_destroy();
		$this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
        $this->zfcUserAuthentication()->getAuthService()->clearIdentity();
		$result = new JsonModel(array(					
			'output' => 'success',
			'success'=>false,
		));		
		return $result;		
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
	 public function userRedirectAction()
    {
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];

		$row = $this->getUserTable()->checkDetailsRecorded($_SESSION['Zend_Auth']->storage);
		if( $row->countUser == 0 )
		{
			
			$user_details_id = $this->getUserDetailsTable()->addUserDetails( $_SESSION['Zend_Auth']->storage, 'update');
			$userInfo['status']=1;
			$userInfo['userId']=$_SESSION['Zend_Auth']->storage;
			$userRoww = $this->getUserTable()->changeAccountStatus( $userInfo, 'update');
			$userRow = $this->getUserTable()->getUser( $_SESSION['Zend_Auth']->storage );
			$user_session = new Container('user');
			$user_session->user_id=$userRow->user_id;
			$user_session->email=$userRow->email;
			$user_session->displayName=$userRow->display_name;
		}
		else
		{
			$userInfo['status']=1;
			$userInfo['userId']=$_SESSION['Zend_Auth']->storage;			
			$user_details_id = $this->getUserDetailsTable()->addUserDetails( $_SESSION['Zend_Auth']->storage, 'insert' );
			$userRoww = $this->getUserTable()->changeAccountStatus( $userInfo, 'insert');
			$userRow = $this->getUserTable()->getUser( $_SESSION['Zend_Auth']->storage );
			$row = $this->getUserTable()->updateAddedDate($_SESSION['Zend_Auth']->storage,$userRow->display_name);
			$user_session = new Container('user');
			$user_session->user_id=$userRow->user_id;
			$user_session->email=$userRow->email;
			$user_session->displayName=$userRow->display_name;	
		}

		$view = new ViewModel(
			array(
				'baseUrl' 	=> $baseUrl,
				'basePath' 	=> $basePath,
			));
		return $this->redirect()->toUrl($baseUrl);
	}
	//Static pages
	
	public function aboutAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$view = new ViewModel(
			array(
				'baseUrl' 	=> $baseUrl,
				'basePath' 	=> $basePath,
			));
		return $view;
	}
	public function privacyPolicyAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$view = new ViewModel(
			array(
				'baseUrl' 	=> $baseUrl,
				'basePath' 	=> $basePath,
			));
		return $view;
	}
	public function termsConditionsAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$view = new ViewModel(
			array(
				'baseUrl' 	=> $baseUrl,
				'basePath' 	=> $basePath,
			));
		return $view;
	}
	public function contactUsAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		include('public/PHPMailer_5.2.4/sendmail.php');	
		global $contactusSubject;				
		global $contactusMessage;
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$output="";
		if(isset($_POST['contactEmail']) && $_POST['contactEmail']!=""){
			$userName  		= ucfirst($_POST['firstName'].' '. $_POST['lastName']);
			$userEmail 		= $_POST['contactEmail'];
			$usermessage   	= $_POST['contactMessage'];
			$mobilenumber   = $_POST['mobileNumber'];
			$contactusMessage = str_replace("<FULLNAME>",$userName, $contactusMessage);				
			$contactusMessage = str_replace("<EMAIL>",$userEmail, $contactusMessage);
			$contactusMessage = str_replace("<MOBILENUMBER>",$mobilenumber, $contactusMessage);
			$contactusMessage = str_replace("<SUBJECT>",$usermessage, $contactusMessage);
			$to='info@sfadda.com';				
			$from_du=$userEmail;				
			if(sendMail($to,$contactusSubject,$contactusMessage,$from_du)){		
				$output ='success' ;
			}else{
				$output ='fail' ;
			}			
		}
		$view = new ViewModel(
			array(
				'baseUrl' 	=> $baseUrl,
				'basePath' 	=> $basePath,
				'output' 	=> $output,
			));
		return $view;
		
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
	public function getUserDetailsTable()
    {
        if (!$this->userDetailsTable) {				
            $sm = $this->getServiceLocator();
            $this->userDetailsTable = $sm->get('Users\Model\UserDetailsFactory');			
        }
        return $this->userDetailsTable;
    }
	public function getCategoryTable()
    {
        if (!$this->categoriesTable) {				
            $sm = $this->getServiceLocator();
            $this->categoriesTable = $sm->get('Users\Model\CategoryFactory');			
        }
        return $this->categoriesTable;
    }
	public function getVideoTable()
    {
        if (!$this->videoTable) {				
            $sm = $this->getServiceLocator();
            $this->videoTable = $sm->get('Users\Model\VideoFactory');			
        }
        return $this->videoTable;
    }
}