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
		$allTests 	= $testTable->UsersList();				
		$userImages	= $testTable->UserImagesList();		
		  $routes=$this->params()->fromRoute();
		$vid='';
		if(isset($routes['id']) && $routes['id']!=""){
			$vid = $routes['id'];
		}		
		$paginator = $testTable->videoTitleList(true,$vid);
		//print_r($paginator);exit;
		//echo (int)$this->params()->fromQuery('page',1);exit;
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
	/* public function headerAction($params)
    {
		$baseUrls = $this->getServiceLocator()->get('config');
		$testTable 	= $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');		
		$baseUrlArr = $baseUrls['urls'];
		 $baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$videoList = $testTable->videoUpdatesList();
		//echo '<pre>';print_r($videoList);		
		$homePageVideos = $testTable->homePageVideos();
		//echo '<pre>';print_r($homePageVideos);
		$topVideos=array();
		$featuredVideos=array();
		$lastedVideos=array();
		if($homePageVideos!="") {
			$i=0; foreach($homePageVideos as $videosH){
				if( $i<=6 ){
					$topVideos[] = $videosH; 
				}	
				if( $i>=7 && $i<23 ){
					$featuredVideos[] = $videosH; 
				}
				if($i>=15){			
					$lastedVideos[] = $videosH;
				 }
			$i++; }
		}		
		
		
		return $this->layout()->setVariable(
			"headerarray",array(
				'baseUrl' 		=> 	$baseUrl,
				'basePath'		=>	$basePath,				
				'videoData'		=>	$videoList,
				'topVideos'	    =>	$topVideos,
				'featuredVideos'=>	$featuredVideos,
				'lastedVideos'	=>	$lastedVideos,
			)
		);
	}	 */
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
		//echo 'k';
		 $id = $this->params()->fromRoute('id', 0);
		 //echo $id;exit;
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$testTable 	= $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');
		//$routes=$this->params()->fromQuery('id');
		//print_r($routes);exit;
		$allTests 	= $testTable->UsersProfileList($id);
		//print_r($allTests);
		$user_session = new Container('user');
		$user_session->username=$id;
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,				
				'allTests' 					=> $allTests,				
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
		$allTests 	= $testTable->EditProfile($base_user_id)->current();
			//print_r($allTests);exit;
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,				
				'allTests' 					=> $allTests,				
				'id'                        => $base_user_id
		));
		
			if(isset($_POST['submit']))
			{
					//print_r($_POST);exit;
					//print_r($_POST['images']);
					//print_r($_FILES['images']);
					$folder='/www/';
					$testTable 	= $this->getServiceLocator()->get('Profiles\Model\UserFactory');		
					$allTests 	= $testTable->UpdateUser($_POST,$id);
					$UpdateTable 	= $this->getServiceLocator()->get('Profiles\Model\ProfileFactory');	
					$allTests 	= $UpdateTable->UpdateUser($_POST,$id);
					if($allTests>0)
					{
						return $this->redirect()->toUrl($baseUrl.'/profile-user/'.$base_user_id);
					}
			}
			
			
			return $viewModel;
		
	}
	public function categoriesAction()
	{
		
	}
	
	
}