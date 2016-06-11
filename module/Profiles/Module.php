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

use Profiles\Model\Category;
use Profiles\Model\CategoryTable;
use Profiles\Model\UserSkills;
use Profiles\Model\UserSkillsTable;
use Profiles\Model\City;
use Profiles\Model\CityTable;
use Profiles\Model\Languages;
use Profiles\Model\LanguagesTable;


class Module implements 
	Feature\AutoloaderProviderInterface,
    Feature\ConfigProviderInterface,
    Feature\ServiceProviderInterface
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
			),			
        );
    }
}