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
	protected  $userDetailsTable;
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
	public function changePasswordAction(){
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
					$user_session->username=$userDetails->username;
					$user_session->displayname=$userDetails->display_name;
					$user_session->email=$userDetails->email;
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
	public function dashboardMenuAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$view= new ViewModel(array(
			'basePath'=>$basePath,
		));
		return $view;
	}
	public function addCategoryAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];	
		if(isset($_POST['cat_id']) && $_POST['cat_id']!=''){
			$updatecatid = $this->getCategoryTable()->addCategories($_POST,$_POST['cat_id']);
			if($updatecatid>=0){
				$cntSubCat = $this->getCategoryTable()->cntSubCat($_POST['cat_id']);
				if($cntSubCat!=0){
					$delSuccess = $this->getCategoryTable()->delSubCategories($_POST['cat_id']);
				}
				if(isset($_POST['cat_name']) && $_POST['cat_name']!=''){
					foreach($_POST['cat_name'] as $subcatname){
						$addSubCategory = $this->getCategoryTable()->addSubCategory($subcatname,$_POST['cat_id']);	
					}
				}
				return $this->redirect()->toUrl('categories-list');
			}			
		}else if(isset($_POST['catname']) && $_POST['catname']!='' && $_POST['cat_id']==''){
			$addcatid = $this->getCategoryTable()->addCategories($_POST,$_POST['cat_id']);
			if($addcatid!=""){
				if(isset($_POST['cat_name']) && $_POST['cat_name']!=''){
					foreach($_POST['cat_name'] as $subcatname){
						$addSubCategory = $this->getCategoryTable()->addSubCategory($subcatname,$addcatid);	
					}
				}
				return $this->redirect()->toUrl('categories-list');
			}
		}else if(isset($_GET['cid']) && $_GET['cid']!=""){
			$catDetails = $this->getCategoryTable()->editCategories($_GET['cid']);
			$catData = array();
			$subcatData = array();
			foreach($catDetails as $key=>$catInfo){
				$catData['category_id']=$catInfo->category_id;
				$catData['category_name']=$catInfo->category_name;
				$subcatData[$catInfo->subcategory_id] =$catInfo->subcategory;
			}			
			return new ViewModel(array(
				'catData'	  =>  $catData,
				'subcatData'  =>  $subcatData,
				'basePath'	  =>  $basePath,	
			));
		}
			
	}
	public function getCategoryTable()
    {
        if (!$this->categoriesTable) {				
            $sm = $this->getServiceLocator();
            $this->categoriesTable = $sm->get('Users\Model\CategoryFactory');			
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
	public function usersListAction()
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
	public function userinfoAjaxAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$usersTable=$this->getUserTable();
		$userDetailss = $usersTable->listUsers();
		$data = array();
		$i=0;
		if(isset($userDetailss) && $userDetailss->count()!=0){
		 $catTypeName="";
			foreach($userDetailss as $user){
				$id=$user->user_id;
				$data[$i]['user_id']=$i+1;
				$data[$i]['user_name']= $user->username;
				$data[$i]['email_id']= $user->email;
				$data[$i]['contact_number']= $user->contact_number;
				if($user->state==1){
					$status = 'Active';
					$st = 'd';
				}else{
					$status = 'Deactivate';
					$st = 'a';
				}
				$data[$i]['status']= $status;
				$data[$i]['action'] ='<a href="'.$baseUrl.'/admin/edit-user-profile?uid='.$id.'">Edit</a>&nbsp;/&nbsp;<a href="'.$baseUrl.'/admin/delete-user?uid='.$id.'&st='.$st.'">'.$status.'</a>';
				$i++;
			}
			$data['aaData'] = $data;
			echo json_encode($data['aaData']); exit;
		}else{
			echo '1'; exit;
		}
	}
	public function deleteUserAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_GET['uid']) && $_GET['uid']!=""){
			if( $_GET['st'] == 'd'){
				$userInfo['status']=0;
			}else{
				$userInfo['status']=1;
			}
			$userInfo['userId'] = $_GET['uid'];
			$chgStatus = $this->getUserTable()->changeAccountStatus($userInfo,'del');
			if($chgStatus>0){
				return $this->redirect()->toUrl($baseUrl.'/admin/users-list');
			}
		}
	}
	public function editUserProfileAction(){
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		if(isset($_POST['hid_user_id']) && $_POST['hid_user_id']!=''){	
			$base_user_id = $_POST['hid_user_id'];
			$user_id=$this->getUserTable()->addUser($_POST,$_POST['hid_user_id']);
			$suc = 'udt';
			if($user_id>=0){
				$user_idd=$this->getUserDetailsTable()->addDetails($_POST,$_POST['hid_user_id'],$_POST['hid_ud_id']);
				return $this->redirect()->toUrl($baseUrl.'/admin/users-list');
			}
		}else if(isset($_GET['uid']) && $_GET['uid']!=""){
			$base_user_id = $_GET['uid'];
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
	public function categoryAjaxAction()
	{
		$baseUrls = $this->getServiceLocator()->get('config');
		$baseUrlArr = $baseUrls['urls'];
		$baseUrl = $baseUrlArr['baseUrl'];
		$basePath = $baseUrlArr['basePath'];
		$getCategoryList = $this->getCategoryTable()->getCategoryList();
		$data = array();
		$i=0;
		if(isset($getCategoryList) && $getCategoryList->count()!=0){
		 $catTypeName="";
			foreach($getCategoryList as $categories){				
                $id=$categories->category_id;
				$data[$i]['category_id']=$i+1;
				$data[$i]['category_name']= $categories->category_name;
				$data[$i]['action'] ='<a href="'.$baseUrl.'/admin/add-category?cid='.$id.'">Edit</a>&nbsp;/&nbsp;<a href="javascript:void(0);" onClick="deleteCategory('.$id.')">Delete</a>';
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
	public function getUserDetailsTable()
    {
        if (!$this->userDetailsTable) {				
            $sm = $this->getServiceLocator();
            $this->userDetailsTable = $sm->get('Users\Model\UserDetailsFactory');			
        }
        return $this->userDetailsTable;
    }	
}