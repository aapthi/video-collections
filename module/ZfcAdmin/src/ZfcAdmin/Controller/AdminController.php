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
	protected  $categoriesTable;
	public function indexAction()
	{
		
	}
	public function logoutAction(){	
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		unset($_SESSION['admin']);
		return $this->redirect()->toUrl($baseUrl.'/admin');
	}
	public function headerAction($params)
    {
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		return $this->layout()->setVariable(
			"headerarray",array(
				'baseUrl' => $baseUrl,
			)
		);
	}
	public function getUserTable()
    {
        if (!$this->userTable) {				
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Users\Model\UserTableFactory');			
        }
        return $this->userTable;
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
					$user_session = new Container('admin');
					$user_session->username=$userDetails->user_name;
					$user_session->email=$userDetails->email_id;
					$user_session->user_id=$user_id;
					$result = new JsonModel(array(					
						'output' => 'success',
						'user_id' => json_decode($user_id),
						'user_type' => 'admin',
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
	public function dashboardAction(){
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
	public function getCategoryTable()
    {
        if (!$this->categoriesTable) {				
            $sm = $this->getServiceLocator();
            $this->categoriesTable = $sm->get('Application\Model\CategoryFactory');			
        }
        return $this->categoriesTable;
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
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$editcatid = $this->getCategoryTable()->editCategories($editcatid);
		$view= new ViewModel(array(
				'editcatdata'=>$editcatid->toArray(),
			));
		return $view;
	}	
	public function deleteCategoryAction()
	{		  
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
}