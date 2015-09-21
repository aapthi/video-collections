<?php
namespace ZfcAdmin\Controller;
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
class AdminController extends AbstractActionController
{
	protected  $userTable;
	protected  $issuesTable;
	protected  $categoriesTable;
	public function indexAction()
	{
		
	}
	public function dashBoardAction()
	{
		
	}
	public function addIssueAction()
	{
		$getCategories=$this->getCategoryTable()->getCategories();
		$baseUrls 	= $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl 	= $baseUrlArr['baseUrl'];
		$basePath 	= $baseUrlArr['basePath'];
		if($_POST){
			if($_POST['hidbutton_value']==0){
				$addIssue = $this->getIssuesTable()->addIssue($_POST);
				return $this->redirect()->toUrl($basePath .'/admin/issues');
			}else{
				$updateIssue = $this->getIssuesTable()->updateIssue($_POST);
				return $this->redirect()->toUrl($basePath .'/admin/issues');
			}
		}else if(isset($_GET['ediid'])!=""){
			$getCategories=$this->getCategoryTable()->getCategories();
			$editIssue = $this->getIssuesTable()->editIssue($_GET['ediid']);
			return  $result = new ViewModel(array(					
				'basepath' 		=> $basePath ,
				'edit_issue'	=> $editIssue->toArray(),
				'categories'	=> $getCategories->toArray(),
			));
		}else{
			return  $result = new ViewModel(array(					
				'basepath' 		=> $basePath ,
				'categories'	=> $getCategories->toArray(),
			));
		}
	}
	public function issuesAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_GET['delid'])){
			$deleteissue=$this->getIssuesTable()->deleteIssue($_GET['delid']);
			return $this->redirect()->toUrl($basePath .'/admin/issues');
		}else{
			return  $result = new ViewModel(array(					
				'basepath' 		=> $basePath ,
			));
		}
	}
	public function issuesAjaxAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$getIssues = $this->getIssuesTable()->getIssues();
		$data = array();$i=0;
		if(isset($getIssues) && $getIssues->count()!=0){
			foreach($getIssues as $issues){
                $id=$issues->issue_id;
				$data[$i]['sno']=$i+1;
				$data[$i]['issue_title']= $issues->issue_title;
				$data[$i]['issue_decription']= $issues->issue_decription;
				$data[$i]['action'] ='<a href="javascript:void(0)" onclick="editIssue('.$id.')" >Edit</a>&nbsp;/&nbsp;<a href="javascript:void(0);" onClick="deleteIssue('.$id.')">Delete</a>';
				$i++;
			}
			$data['aaData'] = $data;
			echo json_encode($data['aaData']); exit;
		}else{
			echo '1'; exit;
		}
	}
	public function addCategoryAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if ($_POST){
			if($_POST['hidbutton_value']==1){
				$updatecatid = $this->getCategoryTable()->updatecatid($_POST);
				return $this->redirect()->toUrl('categories-list');
			}else{
				$addcatid = $this->getCategoryTable()->addCategories($_POST);
				return $this->redirect()->toUrl('categories-list');
			}
		}
		if(isset($_GET['editid']) && $_GET['editid']!=""){
			$editcatid = $this->getCategoryTable()->editCategories($_GET['editid']);
			return new ViewModel(array(
				'editcatdata'	=>  $editcatid->toArray(),
				'basePath'		=>  $basePath,	
			));
		}
			
	}
	public function categoriesListAction()
	{
		
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$view= new ViewModel(array(
					'basePath'=>$basePath,
				));
			return $view;
	}
	
	public function categoryAjaxAction()
	{
		$getCategoryList = $this->getCategoryTable()->getCategoryList();
		$data = array();
		$i=0;
		if(isset($getCategoryList) && $getCategoryList->count()!=0){
		 $catTypeName="";
			foreach($getCategoryList as $categories){
				if($categories->category_type_id==1){
					$catTypeName='Cmspage';
				}else{
					$catTypeName='Headerpage';
				}
                $id=$categories->category_id;
				$data[$i]['category_id']=$i+1;
				$data[$i]['category_name']= $categories->category_name;
				$data[$i]['category_type_id']= $catTypeName;
				$data[$i]['action'] ='<a href="javascript:void(0)" onclick="editCategory('.$id.')" >Edit</a>&nbsp;/&nbsp;<a href="javascript:void(0);" onClick="deleteCategory('.$id.')">Delete</a>';
				$i++;
			}
			$data['aaData'] = $data;
			echo json_encode($data['aaData']); exit;
		}else{
			echo '1'; exit;
		}
	}
	public function editCategoryAction()
	{
	  $editcatid=$_GET['id'];
	  //echo $id; exit;
	  $baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
			$editcatid = $this->getCategoryTable()->editCategories($editcatid);
			$view= new ViewModel(array(
					'editcatdata'=>$editcatid->toArray(),
					// 'url' => $this->redirect()->toRoute('fetch-all'),
				));
			return $view;
		}	
		public function deleteCategoryAction()
		{
		  //$deletecatid=$_GET['id'];
		  //echo $id; exit;
		  $baseUrls = $this->getServiceLocator()->get('config');
		  $baseUrlArr = $baseUrls['urls'];
		  $baseUrl = $baseUrlArr['baseUrl'];
		  $basePath = $baseUrlArr['basePath'];
		  if(isset($_GET['id']))
		  {
            $deleteissue=$this->getCategoryTable()->deleteCategory($_GET['id']);
            return $this->redirect()->toUrl($basePath .'/admin/categories-list');
          }
		}
		
	  
	public function getUserTable()
    {
        if (!$this->userTable) {				
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Users\Model\UserTableFactory');			
        }
        return $this->userTable;
    }
	public function getIssuesTable()
    {
       if (!$this->issuesTable) {                                
           $sm = $this->getServiceLocator();
           $this->issuesTable = $sm->get('ZfcAdmin\Model\IssuesFactory');                        
       }
       return $this->issuesTable;
   }
   
   public function getCategoryTable()
    {
        if (!$this->categoriesTable) {				
            $sm = $this->getServiceLocator();
            $this->categoriesTable = $sm->get('Application\Model\CategoryFactory');			
        }
        return $this->categoriesTable;
    }
}