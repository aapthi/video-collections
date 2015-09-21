<?php 
namespace Users\Factory\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\Feature;

use Users\Model\EntranceExam;
use Users\Model\EntranceExamTable;

class EntranceExamTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $db = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new HydratingResultSet();
        $resultSetPrototype->setHydrator(new ObjectProperty());
        $resultSetPrototype->setObjectPrototype(new EntranceExam());
        $tableGateway       = new TableGateway('tbl_entrance_exam', $db,array(),$resultSetPrototype);
        $table              = new EntranceExamTable($tableGateway);
        return $table;
    }
}