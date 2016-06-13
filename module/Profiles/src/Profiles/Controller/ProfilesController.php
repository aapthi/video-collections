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
	//protected  $userTable;		
	
	public function indexAction()
	{
		
	/* 	Index  */		
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];	
		$testTable 	= $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');
		$userTable 	= $this->getServiceLocator()->get('Profiles\Model\UserFactory');		
		$allTests 	= $testTable->UsersList();				
		$allTests 	= $userTable->UsersList();				
		$userImages	= $testTable->UserImagesList();		
		  $routes=$this->params()->fromRoute();
		$vid='';
		if(isset($routes['id']) && $routes['id']!=""){
			$vid = $routes['id'];
		}		
		$paginator = $testTable->videoTitleList(true,$vid);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page',1));
		$paginator->setItemCountPerPage(2);	
		$paginator->setPageRange(5);
		
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,			
				'vatTData' 					=> $paginator,
				'id'                        => $vid,
				'allTests' 					=> $allTests,			
				'userImages' 				=> $userImages
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
		
		$id = $this->params()->fromRoute('id', 0);		 
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$testTable 	= $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');		
		$allTests 	= $testTable->UsersProfileList($id);
		$UserVideoTable 	= $this->getServiceLocator()->get('Profiles\Model\UserVideoFactory');		
		$videos 	= $UserVideoTable->videoList(base64_encode($id));
		$UserSkillsTable 	= $this->getServiceLocator()->get('Profiles\Model\UserSkillsFactory');		
		$skills 	= $UserSkillsTable->skillsList(base64_encode($id));
		$UserPicsTable 	= $this->getServiceLocator()->get('Profiles\Model\UserPicsFactory');		
		$pics 	= $UserPicsTable->picList($id);
		//print_r($skills);exit;
		$user_session = new Container('user');
		$user_session->username=$id;
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,				
				'allTests' 					=> $allTests,				
				'videos' 					=> $videos,				
				'pics' 					=> $pics,				
				'skills' 					=> $skills,				
				'id'                        => ''
		));
		return $viewModel;		
	}
	public function editProfileAction()
	{		
		$id = $this->params()->fromRoute('uid', 0);
		$base_user_id = base64_decode($id);		
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$testTable 	= $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');		
		$userCategoriesTable	=$this->getServiceLocator()->get('Profiles\Model\CatFactory');
		$CityTable 	= $this->getServiceLocator()->get('Profiles\Model\CityFactory');	
		$cities 	= $CityTable->cityList();		
		$LangTable 	= $this->getServiceLocator()->get('Profiles\Model\LanguagesFactory');	
		$lang 	= $LangTable->languagesList();
		$UserSkillsTable 	= $this->getServiceLocator()->get('Profiles\Model\UserSkillsFactory');	
		$skill 	= $UserSkillsTable->skillsList($id);		
		$UserVideoTable 	= $this->getServiceLocator()->get('Profiles\Model\UserVideoFactory');
		$UserPicsTable 	= $this->getServiceLocator()->get('Profiles\Model\UserPicsFactory');
		$allSkills 	= $userCategoriesTable->CategoryList();
		//file uploading
			
		
		if(isset($_POST['submit']) && $_POST['submit']!=""){				
			$target_dir = "public/upload/";			
			$target_file =$target_dir.basename($_FILES["fileToUpload"]["name"]);					
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$allTests 	= $testTable->UpdateUser($_POST,$id,$target_file);
				}
			$target_path = "public/useruploads/";
			for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
				$target_files =$target_path.basename($_FILES["images"]["name"][$i]);
				//print_r($target_files);
				if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $target_files)) {
				$images 	= $UserPicsTable->insertImages($id,$target_files);	
				}
				
			}
			$testTable 	= $this->getServiceLocator()->get('Profiles\Model\UserFactory');		
			$allTests 	= $testTable->UpdateUser($_POST,$id,$target_file);
			$UserSkillsTable 	= $this->getServiceLocator()->get('Profiles\Model\UserSkillsFactory');	
			$allTests 	= $UserSkillsTable->addUserSkills($_POST,$id);			
			$UpdateTable 	= $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');	
			$allTests 	= $UpdateTable->UpdateUser($_POST,$id,$target_file);
			$UserVideoTable 	= $this->getServiceLocator()->get('Profiles\Model\UserVideoFactory');	
			$allTests 	= $UserVideoTable->UpdateUserVideo($_POST,$id);
			
			//$allTests 	= $UserVideoTable->videoList($id);
			//print_r($allTests);exit;			
				return $this->redirect()->toUrl($baseUrl.'/profile-user/'.$base_user_id);			
		// List 
		}else{
			$catList = $userCategoriesTable->CategoryList();
			$videos 	= $UserVideoTable->videoList($id);			
			$allTests 	= $testTable->EditProfile($base_user_id)->current();						
			$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,				
				'allTests' 					=> $allTests,				
				'cities' 					=> $cities,									
				'videos' 					=> $videos,									
				'skill' 					=> $skill,									
				'allSkills' 					=> $allSkills,									
				'lang' 					    => $lang,				
				'id'                        => $base_user_id,
				'catList'                   => $catList
			));
			return $viewModel;	
		}			
	}
}