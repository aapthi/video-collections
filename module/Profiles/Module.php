<?php
namespace Profiles;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature;
use Zend\Loader;
use Zend\EventManager\EventInterface;
use Zend\Mvc\Router\RouteMatch;
use Zend\ModuleManager\ModuleManager;
use Zend\Stdlib\Hydrator\ClassMethods;
/* Helpers Method */
use Zend\ModuleManager\Feature\ViewHelperProviderInterface; 

use Profiles\Model\Category;
use Profiles\Model\CategoryTable;
use Profiles\Model\UserSkills;
use Profiles\Model\UserSkillsTable;
use Profiles\Model\City;
use Profiles\Model\CityTable;
use Profiles\Model\Languages;
use Profiles\Model\LanguagesTable;
use Profiles\Model\ViewProfileCount;
use Profiles\Model\ViewProfileCountTable;


class Module implements 
	Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\ServiceProviderInterface,
	/* Helper Implements Method */
    Feature\ViewHelperProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
			),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }    
    public function getServiceConfig()
    {
        return array(
            'factories' => array( 
				'Profiles\Model\ProfileFactory'=>'Profiles\Factory\Model\ProfileTableFactory',
				'Profiles\Model\UserFactory'=>'Profiles\Factory\Model\UserTableFactory',
				'Profiles\Model\CatFactory'=>'Profiles\Factory\Model\CatTableFactory',
				'Profiles\Model\UserSkillsFactory'=>'Profiles\Factory\Model\UserSkillsTableFactory',
				'Profiles\Model\CityFactory'=>'Profiles\Factory\Model\CityTableFactory',
				'Profiles\Model\LanguagesFactory'=>'Profiles\Factory\Model\LanguagesTableFactory',
				'Profiles\Model\UserVideoFactory'=>'Profiles\Factory\Model\UserVideoTableFactory',
				'Profiles\Model\UserPicsFactory'=>'Profiles\Factory\Model\UserPicsTableFactory',
				'Profiles\Model\ViewProfileCountFactory'=>'Profiles\Factory\Model\ViewProfileCountTableFactory',
			),			
        );
    }
	/* Set View HelperConfig */
	public function getViewHelperConfig()
	{
		return array(
			'factories' => array(
				'profile_helper' => function($sl) {
					$sm = $sl->getServiceLocator(); 
					$helper = new View\Helper\Profilehelper($sm);
					return $helper;
				}
			)
		);   
   }
   /* End */
}