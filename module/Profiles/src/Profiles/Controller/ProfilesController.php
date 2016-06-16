<?php
namespace Profiles\Controller;
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

class ProfilesController extends AbstractActionController
{
	public function indexAction()
	{
		
	}
	public function viewProfileCountAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];	
		$viewProfileCountTable	= $this->getServiceLocator()->get('Profiles\Model\ViewProfileCountFactory');
		if(isset($_POST['vpc_pu_id']) && $_POST['vpc_pu_id']!=""){
			$vpc_pu_id = $_POST['vpc_pu_id']; // Profile user id Viewing on
			$vpc_vu_id = $_SESSION['user']['user_id']; // Logged User Id -- Viewer By
			$getLastActivityLoggedU  = $viewProfileCountTable->getUserCount($vpc_pu_id,$vpc_vu_id);
			$time_diff_Lu = 0;
			if($getLastActivityLoggedU!=""){
				$time_diff_Lu = time() - strtotime($getLastActivityLoggedU->vpc_updated_at);
				$minutes_lu = floor($time_diff_Lu / 60);
				if($minutes_lu>1){
					$addedViewerCount 	  = $viewProfileCountTable->addViewCount($vpc_pu_id,$vpc_vu_id,$count=1);
					if($addedViewerCount>=1){
						return $jsonModel = new JsonModel(array(
							'output' => 'success',
						));
					}	
				}else{
					return $jsonModel = new JsonModel(array(
						'output' => 'process',
					));
				}
			}else{
				$addedViewerCount 	  = $viewProfileCountTable->addViewCount($vpc_pu_id,$vpc_vu_id,$count=1);
				if($addedViewerCount>=1){
					return $jsonModel = new JsonModel(array(
						'output' => 'success',
					));
				}	
			}
		}else{
			return $jsonModel = new JsonModel(array(
					'output' => 'fail'
			));
		}
	}	
	public function allProfilesAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];	
		$userTable 	= $this->getServiceLocator()->get('Users\Model\UserTableFactory');
		$languagesTable	= $this->getServiceLocator()->get('Profiles\Model\LanguagesFactory');
		if(isset($_GET['u_name']) && $_GET['u_name']!=''){
			if( $_GET['cat']!='all' ){
				$catid=$_GET['cat'];				
			}else{
				$catid=0;	
			}
			if(isset($_GET['city']) && $_GET['city']!='' ){
				$cid=$_GET['city'];				
			}else{
				$cid=0;	
			}
			$userName= $_GET['u_name'];
		}else if(isset($_GET['city']) && $_GET['city']!=''){
			if($_GET['cat']=='all'){
				$catid=0; 
			}else{
				$catid=$_GET['cat']; 
			}
			$cid =$_GET['city'];
			$userName=0;
		}else if(isset($_GET['cat']) && $_GET['cat']!=''){
			if( $_GET['cat']!='all'){
				$catid=$_GET['cat'];				
			}else{
				$catid=0;	
			}
			$cid =0;
			$userName=0;
		}else{
			$catid=0;	
			$cid =0;
			$userName=0;	
		}	
		$paginator 	= $userTable->allUsersData($catid,$cid,$userName);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page',1));
		$paginator->setItemCountPerPage(2);	
		$paginator->setPageRange(5);
		// echo "<pre>";print_r($paginator);exit;
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,			
				'vatTData' 					=> $paginator
		));
		return $viewModel;	
	}
	public function searchResultAction()
    {
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$testTable 	= $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');
		$allTests 	= $testTable->UsersList();	
		$routes=$this->params()->fromRoute();
		//$searchres =str_replace('-',' ',$routes['search_name']);
		$paginator = $testTable->getSearchResults($routes,true);		
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(2);
		$paginator->setPageRange(5);
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,				
				'vatFData' 					=> $allTests,
				'vatTData' 					=> $paginator,
				'id'                        => ''
		));
		return $viewModel;
    }
	public function viewProfileUserAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		
		$testTable 	      = $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');		
		$UserVideoTable   = $this->getServiceLocator()->get('Profiles\Model\UserVideoFactory');
		$UserSkillsTable  = $this->getServiceLocator()->get('Profiles\Model\UserSkillsFactory');
		$UserPicsTable 	  = $this->getServiceLocator()->get('Profiles\Model\UserPicsFactory');		
		$LangTable 	= $this->getServiceLocator()->get('Profiles\Model\LanguagesFactory');	
		if(isset($_GET["uid"]) && $_GET['uid']!=""){
			$uid = base64_decode($_GET["uid"]);
			
			$exploadData = explode('-',$uid);
			$id = $exploadData['0'];
		}else{
			$id=0;
		}
		if($id!=0){
			$allTests = $testTable->UsersProfileList($id);
			if($allTests->count()>0){
				$userArray = "";
				$resultSet = $allTests->toArray(); 
				foreach($resultSet as $uData){					
					$userArray["langNames"]=array();
					$userArray= $uData;
					if($uData['languages']!=""){
						$explodeData = explode(",",$uData['languages']);
						foreach($explodeData as $key=>$lan_id){
							$langNames = $LangTable->getUserLang($lan_id)->toArray();
							foreach($langNames as $lName){
								$userArray["langNames"][] = $lName['lang_name'];
							}
						}
					}else{
						$userArray["langNames"][] ="";
					}					
				}
			}
			$videos   = $UserVideoTable->videoList($id);		
			$skills   = $UserSkillsTable->skillsList($id);			
			$pics 	  = $UserPicsTable->picList($id);		
			$viewModel = new ViewModel(
				array(
					'baseUrl'				 	=> $baseUrl,
					'basePath' 					=> $basePath,				
					'allTests' 					=> $userArray,				
					'videos' 					=> $videos,				
					'pics' 					    => $pics,				
					'skills' 					=> $skills,				
			));
			return $viewModel;	
		}else{
			return $this->redirect()->toUrl($baseUrl.'/all-profiles?cat=all');
		}		
	}
	public function editProfileAction()
	{		
		$baseUrls    = $this->getServiceLocator()->get('config');
		$baseUrlArr  = $baseUrls['urls'];
		$baseUrl     = $baseUrlArr['baseUrl'];
		$basePath    = $baseUrlArr['basePath'];
		$userTable 	         = $this->getServiceLocator()->get('Users\Model\UserTableFactory');		
		$testTable 	         = $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');		
		$userCategoriesTable = $this->getServiceLocator()->get('Profiles\Model\CatFactory');
		$CityTable 	         = $this->getServiceLocator()->get('Profiles\Model\CityFactory');	
		$LangTable 	         = $this->getServiceLocator()->get('Profiles\Model\LanguagesFactory');
		$UserPicsTable       = $this->getServiceLocator()->get('Profiles\Model\UserPicsFactory');
		$UserSkillsTable 	 = $this->getServiceLocator()->get('Profiles\Model\UserSkillsFactory');	
		$UserVideoTable 	 = $this->getServiceLocator()->get('Profiles\Model\UserVideoFactory');		
		$lang 	    = $LangTable->languagesList();					
		$allSkills 	= $userCategoriesTable->CategoryList();
		$cities 	= $CityTable->cityList();
		if(isset($_POST['hid_u_id']) && $_POST['hid_u_id']!=""){
			$u_id = $_POST['hid_u_id'];
			// echo "<pre>";print_r($_POST);
			// echo "<pre>";print_r($_FILES);
			// exit;
			if(isset($_FILES["fileToUpload"]["name"]) && $_FILES["fileToUpload"]["name"]!=""){
				$target_dir = "./public/upload/";			
				$target_file =$target_dir.basename($_FILES["fileToUpload"]["name"]);					
				if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$hid_user_photo = $target_file;
				}
			}else{
				if(isset($_POST['hid_user_photo']) && $_POST['hid_user_photo']!=""){
					$hid_user_photo = $_POST['hid_user_photo'];	
				}else{
					$hid_user_photo = '';	
				}
			}
			if(isset($_FILES['images']['name']) && $_FILES['images']['name']!=""){
				$target_path = "./public/useruploads/";
				for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
					$target_files =$target_path.basename($_FILES["images"]["name"][$i]);
					if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_files)) {
						$images 	= $UserPicsTable->insertImages($u_id,$target_files);	
					}				
				}
			}
			$addSkills       = $UserSkillsTable->addUserSkills($_POST,$u_id);
			$updateVideos 	 = $UserVideoTable->UpdateUserVideo($_POST,$u_id);
			$updateUDetails  = $testTable->UpdateUserD($_POST,$u_id,$hid_user_photo);
			$updateUsers 	 = $userTable->updateUser($_POST,$u_id);
			$base_user_id = base64_encode($u_id.'-143');
			$user_session = new Container('user');
			$user_session->username=$_POST['fname'];
			$user_session->displayName=$_POST['fname'];
			if($updateUsers){
				return $this->redirect()->toUrl($baseUrl.'/profile-user?uid='.$base_user_id);
			}else{
				return $this->redirect()->toUrl($baseUrl.'/profile-user?uid='.$base_user_id);
			}			
		}else if(isset($_GET["uid"]) && $_GET['uid']!=""){
			$uid = base64_decode($_GET["uid"]);			
			$exploadData = explode('-',$uid);
			$id = $exploadData['0'];
			$allTests = $testTable->UsersProfileList($id);
			$resultSet = $allTests->current(); 
			$videos 	= $UserVideoTable->videoList($id);
			$skill 	   = $UserSkillsTable->skillsList($id);
			$pics 	  = $UserPicsTable->picList($id);	
			$viewModel = new ViewModel(array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,				
				'allTests' 					=> $resultSet,				
				'cities' 					=> $cities,									
				'allSkills' 				=> $allSkills,									
				'lang' 					    => $lang,				
				'id'                        => $uid,
				'videos'                    => $videos,
				'skill'                     => $skill,
				'pics'                     => $pics
			));
			return $viewModel;
		}		
	}
}