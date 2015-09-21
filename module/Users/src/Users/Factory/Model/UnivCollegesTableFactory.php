<?php 
namespace Users\Factory\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\Feature;

use Users\Model\UnivColleges;
use Users\Model\UnivCollegesTable;

class  UnivCollegesTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
		$db = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new HydratingResultSet();
        $resultSetPrototype->setHydrator(new ObjectProperty());
        $resultSetPrototype->setObjectPrototype(new UnivColleges());
        $tableGateway       = new TableGateway('tbl_colleges_univ', $db,array(),$resultSetPrototype);
        $table              = new UnivCollegesTable($tableGateway);
        return $table;
    }
}