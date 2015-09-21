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


use Users\Model\UserType;
use Users\Model\UserTypeTable;
use Users\Model\User;
use Users\Model\UserTable;
use Users\Model\UserDetails;
use Users\Model\UserDetailsTable;
use Users\Model\UserPersonalInfo;
use Users\Model\UserPersonalInfoTable;
use Users\Model\ForgotPassword;
use Users\Model\ForgotPasswordTable;
use Users\Model\Countries;
use Users\Model\CountriesTable;
use Users\Model\States;
use Users\Model\StatesTable;
use Users\Model\Districts;
use Users\Model\DistrictsTable;
use Users\Model\EntranceExam;
use Users\Model\EntranceExamTable;
use Users\Model\Specialization;
use Users\Model\SpecializationTable;
use Users\Model\Universities;
use Users\Model\UniversitiesTable;
use Users\Model\Colleges;
use Users\Model\CollegesTable;
use Users\Model\Payment;
use Users\Model\PaymentTable;
use Users\Model\UnivColleges;
use Users\Model\UnivCollegesTable;
use Users\Model\Branches;
use Users\Model\BranchesTable;


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
            	'Users\Model\UserDetailsFactory'=>'Users\Factory\Model\UserDetailsTableFactory'            	   	
			),			
        );
    }
}