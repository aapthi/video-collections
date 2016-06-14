<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Zend\View\Model\JsonModel;
class IndexController extends AbstractActionController
{
	protected  $categoriesTable;
	protected  $videoTable;
	protected  $hitsTable;
	protected  $catTable;
	
    public function indexAction()
    {
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$catList = $this->getCategoryTable()->getCategoryListD();		
		$videoList = $this->getVideoTable()->videoForentedList();		
		$videoFList = $this->getVideoTable()->videoFeaturedList();
		$routes=$this->params()->fromRoute();
		$vid='';
		if(isset($routes['id']) && $routes['id']!=""){
			$vid = $routes['id'];
		}
		$paginator = $this->getVideoTable()->videoTitleList(true,$vid);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page',1));
		$paginator->setItemCountPerPage(100);	
		$paginator->setPageRange(5);
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,
				'catData' 					=> $catList,
				'vatData' 					=> $videoList,
				'vatFData' 					=> $videoFList,
				'vatTData' 					=> $paginator,
				'id'                        => $vid
		));
		return $viewModel;
    }
	public function searchResultAction()
    {
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$catList = $this->getCategoryTable()->getCategoryListD();		
		$videoList = $this->getVideoTable()->videoForentedList();		
		$videoFList = $this->getVideoTable()->videoFeaturedList();
		$routes=$this->params()->fromRoute();
		$paginator = $this->getVideoTable()->getSearchResults($routes,true);		
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(39);
		$paginator->setPageRange(5);
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,
				'catData' 					=> $catList,
				'vatData' 					=> $videoList,
				'vatFData' 					=> $videoFList,
				'vatTData' 					=> $paginator,
				'id'                        => ''
		));
		return $viewModel;
    }
	public function viewprofileAction()
    {
		//echo "dasdfasdfas";
		//return $result;
	}
	public function viewAction()
    {
		//echo "dasdfasdfas";
		//return $result;
	}
	public function view1Action()
    {
		//echo "dasdfasdfas";
		//return $result;
	}
	public function searchTitleResultAction()
    {
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$list_titles=array();
		if(isset($_POST['value']) && $_POST['value']!=""){		
			$getTitles = $this->getVideoTable()->getSearchTilesResults($_POST['value'],true);
			foreach($getTitles as $key=>$search){				
				$list_titles[$search->v_id]=$search->v_title;								
			}
			$combined = array();
			if($list_titles!=''){				
				foreach($list_titles as $key => $refNumber) {	
					$bseEncode = base64_encode($key);
					$combined[] = array(
						'ref'  => $refNumber,
						'part' => $baseUrl.'/play-video?watch='.$bseEncode,
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
	public function playVideoAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$vid = base64_decode($_GET['watch']);				
		$catList = $this->getCategoryTable()->getCategoryListD();		
		$videoList = $this->getVideoTable()->videoForentedList();		
		$videoFList = $this->getVideoTable()->videoFeaturedList();		
		$getVideo = $this->getVideoTable()->videoPlay($vid);
		$getVideoTitle = $this->getVideoTable()->getVideoTitle($vid);
		$_SESSION['tilte_top'] = $getVideoTitle->v_title;
		$_SESSION['tilte_imag'] = $getVideoTitle->v_thumb_image;
		$getCatInfo = $this->getVideoTable()->getCategory($vid);
		if($getCatInfo!=""){
			$catId = $getCatInfo->v_cat_id;
			$videoRList = $this->getVideoTable()->videoRelatedList($catId,$vid);	
		}
		if(isset($_SESSION['user']['user_id']) && $_SESSION['user']['user_id']!=""){
			$userId = $_SESSION['user']['user_id'];			
		}else{
			$userId = $_SERVER['REMOTE_ADDR'];			
		}
		$checkHiting = $this->getHitsTable()->alreadyHit($vid,$userId);
		if($checkHiting == 0){
			$insertedHiting = $this->getHitsTable()->addHit($vid,$userId);			
		}
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,
				'catData' 					=> $catList,
				'vatData' 					=> $videoList,
				'vatFData' 					=> $videoFList,
				'getVideo' 					=> $getVideo,
				'relatedVideos' 			=> $videoRList
		));
		return $viewModel;
		
	}
	public function leftSideBarAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		return $this->layout()->setVariable(
			"headerarray",array(
				'baseUrl' 		=> 	$baseUrl,
				'basePath'		=>	$basePath,				
			)
		);		
	}
	
	public function rightSideBarAction(){
		
		
	}
	public function headerAction($params)
    {
				
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$cityTable 	= $this->getServiceLocator()->get('Profiles\Model\CityFactory');
		$videoList = $this->getVideoTable()->videoUpdatesList();	
		$homePageVideos = $this->getVideoTable()->homePageVideos();
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
			
		$catSubcatlist = array();
		$catCatlist = array();	
		if( $params == "profile" ){
			$catList = $this->getCatTable()->CategoryList();
			$catSubcatlist =$catList;
		}else{
			$catList = $this->getCategoryTable()->getCategoryListF();	
			foreach($catList as $getCatid){
				if(!is_null($getCatid->parent_cat_id)){
					$catSubcatlist[$getCatid->parent_cat_id][$getCatid->category_id] = $getCatid->category_name;
				}else{
					$catSubcatlist[$getCatid->category_id][$getCatid->category_id] = $getCatid->category_name;
				}
			}
        }
		$allCities = $cityTable->cityList();
		return $this->layout()->setVariable(
			"headerarray",array(
				'baseUrl' 		=> 	$baseUrl,
				'basePath'		=>	$basePath,
				'catData'		=>	$catSubcatlist,			
				'videoData'		=>	$videoList,
				'topVideos'	    =>	$topVideos,
				'featuredVideos'=>	$featuredVideos,
				'lastedVideos'	=>	$lastedVideos,
				'allCities'	    =>	$allCities,
				
			)
		);
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
	public function getHitsTable()
    {
        if (!$this->hitsTable) {				
            $sm = $this->getServiceLocator();
            $this->hitsTable = $sm->get('Users\Model\HitsFactory');			
        }
        return $this->hitsTable;
    }
	public function getCatTable()
   {
       if (!$this->catTable) {                
           $sm = $this->getServiceLocator();
           $this->catTable = $sm->get('Profiles\Model\CatFactory');            
       }
       return $this->catTable;
   }
}
