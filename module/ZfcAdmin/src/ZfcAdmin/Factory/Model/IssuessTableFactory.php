<?php 
namespace ZfcAdmin\Factory\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\Feature;

use ZfcAdmin\Model\Issues;
use ZfcAdmin\Model\IssuesTable;

class IssuessTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $db = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new HydratingResultSet();
        $resultSetPrototype->setHydrator(new ObjectProperty());
        $resultSetPrototype->setObjectPrototype(new Issues());
        $tableGateway       = new TableGateway('tbl_issues', $db,array(),$resultSetPrototype);
        $table              = new IssuesTable($tableGateway);
        return $table;
    }
}