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
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(39);	
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
		$searchres =str_replace('-',' ',$routes['search_name']);
		$paginator = $this->getVideoTable()->getSearchResults($searchres,true);
		$paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
		$paginator->setItemCountPerPage(39);
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
		$getCatInfo = $this->getVideoTable()->getCategory($vid);
		if($getCatInfo!=""){
			$catId = $getCatInfo->v_cat_id;
			$videoRList = $this->getVideoTable()->videoRelatedList($catId,$vid);	
		}
		$viewModel = new ViewModel(
			array(
				'baseUrl'				 	=> $baseUrl,
				'basePath' 					=> $basePath,
				'catData' 					=> $catList,
				'vatData' 					=> $videoList,
				'vatFData' 					=> $videoFList,
				'getVideo' 					=> $getVideo,
				'relatedVideos' 					=> $videoRList
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
		$videoList = $this->getVideoTable()->videoUpdatesList();	
		$catSubcatlist = array();
		$catList = $this->getCategoryTable()->getCategoryListF();	
		foreach($catList as $getCatid){
			if(!is_null($getCatid->parent_cat_id)){
				$catSubcatlist[$getCatid->parent_cat_id][$getCatid->category_id] = $getCatid->category_name;					
			}else{
				$catSubcatlist[$getCatid->category_id][$getCatid->category_id] = $getCatid->category_name;
			}
		}
		return $this->layout()->setVariable(
			"headerarray",array(
				'baseUrl' 		=> 	$baseUrl,
				'basePath'		=>	$basePath,
				'catData'		=>	$catSubcatlist,
				'videoData'		=>	$videoList
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
}
