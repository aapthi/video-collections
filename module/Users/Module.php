<?php
namespace Users;
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

use Users\Model\User;
use Users\Model\UserTable;
use Users\Model\UserDetails;
use Users\Model\UserDetailsTable;
use Users\Model\ForgotPassword;
use Users\Model\ForgotPasswordTable;
use Users\Model\Category;
use Users\Model\CategoryTable;
use Users\Model\TypeOfVideo;
use Users\Model\TypeOfVideoTable;
use Users\Model\Video;
use Users\Model\VideoTable;


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
            	'Users\Model\UserTableFactory'=>'Users\Factory\Model\UserTableFactory',			
            	'Users\Model\UserDetailsFactory'=>'Users\Factory\Model\UserDetailsTableFactory',
            	'Users\Model\ForgotPasswordFactory'=>'Users\Factory\Model\ForgotPasswordTableFactory',
				'Users\Model\CategoryFactory'=>'Users\Factory\Model\CategoryTableFactory',
				'Users\Model\TypeOfVideoFactory'=>'Users\Factory\Model\TypeOfVideoTableFactory',
				'Users\Model\VideoFactory'=>'Users\Factory\Model\VideoTableFactory'
			),			
        );
    }
}