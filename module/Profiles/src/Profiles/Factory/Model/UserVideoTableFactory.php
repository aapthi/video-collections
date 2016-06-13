<?php 
namespace  Profiles\Factory\Model;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\Feature;

use Profiles\Model\UserVideo;
use Profiles\Model\UserVideoTable;

class UserVideoTableFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $db = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSetPrototype = new HydratingResultSet();
        $resultSetPrototype->setHydrator(new ObjectProperty());
        $resultSetPrototype->setObjectPrototype(new UserVideo());
        $tableGateway       = new TableGateway('vc_user_videos', $db,array(),$resultSetPrototype);
        $table              = new UserVideoTable($tableGateway);
        return $table;
    }
}