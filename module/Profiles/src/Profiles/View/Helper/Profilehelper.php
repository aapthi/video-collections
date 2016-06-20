<?php
	namespace Profiles\View\Helper;
	use Zend\View\Helper\AbstractHelper;
	use Zend\ServiceManager\ServiceLocatorAwareInterface;
	use Zend\ServiceManager\ServiceLocatorInterface;
    use Zend\View\Exception;
	 
	class Profilehelper extends \Zend\View\Helper\AbstractHelper implements ServiceLocatorAwareInterface
	{
	    
		
		/**
		* @var ServiceLocatorInterface
		*/
		protected $serviceLocator;
		protected $userTable;
	    protected $languageTable;
	    protected $userSkillsTable;
		/**
		* Set the service locator.
		*
		* @param ServiceLocatorInterface $serviceLocator
		* @return AbstractHelper
		*/
		public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
		{
			$this->serviceLocator = $serviceLocator;
			return $this;
		}

		/**
		 * Get the service locator.
		 *
		 * @return \Zend\ServiceManager\ServiceLocatorInterface
		 */
		public function getServiceLocator()
		{
			return $this->serviceLocator;
		}
		
		public function __invoke($str, $find)
		{
			if (! is_string($str)){
				return 'must be string';
			}
	 
			if (strpos($str, $find) === false){
				return 'not found';
			}
	 
			return 'found';
		}
		public function userInformation($lang){
			$userArray ="";
			$explodeData = explode(",",$lang);
			foreach($explodeData as $key=>$lan_id){
				$langNames = $this->getLanguagesTable()->getUserLang($lan_id)->toArray();
				foreach($langNames as $lName){
					$userArray["langNames"][] = $lName['lang_name'];
				}
			}
			return $userArray;
		}
		public function userSkills($uid){
			$skill 	= $this->getUserSkillsTable()->skillsList($uid);			
			return $skill->toArray();
		}
		public function getUsersTable()
		{
			if (null == $this->userTable) {
			  $this->userTable = $this->getServiceLocator()->getServiceLocator()->get('Users\Model\UserTableFactory');
			}
			return $this->userTable;
		}
		public function getUserSkillsTable()
		{
			if (null == $this->userSkillsTable) {
			 $this->userSkillsTable = $this->getServiceLocator()->getServiceLocator()->get('Profiles\Model\UserSkillsFactory');
			}
			return $this->userSkillsTable;
		}
		public function getLanguagesTable()
		{
			if (null == $this->languageTable) {
			  $this->languageTable = $this->getServiceLocator()->getServiceLocator()->get('Profiles\Model\LanguagesFactory');
			}
			return $this->languageTable;
		} 
	}
?>