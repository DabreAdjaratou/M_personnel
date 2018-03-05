<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Session\Container;

class Module implements ConfigProviderInterface {

    const VERSION = '3.0.3-dev';

    public function getConfig() {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        if (php_sapi_name() != 'cli') {
            $eventManager->attach('dispatch', array($this, 'loadConfiguration'));
            //$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'dispatchError'), -999);
        }
//        $eventManager->attach('dispatch', array($this, 'loadConfiguration'));
    }

    public function loadConfiguration(\Zend\Mvc\MvcEvent $e) {
        $controller = $e->getTarget();
        $user_session = new Container('user');
        $acl_container = new Container('acl');
        $user = $user_session->user;
        $acl = $acl_container->acl;
        $role = $user_session->role;
        $controller->layout()->user = $user;
        $controller->layout()->role = $role;
        $controller->layout()->acl = $acl;
        $routeMatch = $e->getRouteMatch();
        $params = $routeMatch->getParams();
        $ressource = substr_replace($params['controller'], '', -10);
        if (isset($acl) && ($acl->isAllowed($role, $ressource, $params['action']) == FALSE)) {
            $viewModel = $e->getViewModel();
            $viewModel->setTemplate('application/user/login');
        }
    }

    public function getServiceConfig() {
        return [
            'factories' => [
                Model\UserTable::class => function($container) {
                    $tableGateway = $container->get(Model\UserTableGateway::class);
                    return new Model\UserTable($tableGateway);
                },
                Model\UserTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\User());
                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },
                Model\PersonnelTable::class => function($container) {
                    $tableGateway = $container->get(Model\PersonnelTableGateway::class);
                    return new Model\PersonnelTable($tableGateway);
                },
                Model\PersonnelTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Personnel());
                    return new TableGateway('personnel', $dbAdapter, null, $resultSetPrototype);
                },
                Model\RegionTable::class => function($container) {
                    $tableGateway = $container->get(Model\RegionTableGateway::class);
                    return new Model\RegionTable($tableGateway);
                },
                Model\RegionTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Region());
                    return new TableGateway('region', $dbAdapter, null, $resultSetPrototype);
                },
                Model\DistrictTable::class => function($container) {
                    $tableGateway = $container->get(Model\DistrictTableGateway::class);
                    return new Model\DistrictTable($tableGateway);
                },
                Model\DistrictTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\District());
                    return new TableGateway('district', $dbAdapter, null, $resultSetPrototype);
                },
                Model\RoleTable::class => function($container) {
                    $tableGateway = $container->get(Model\RoleTableGateway::class);
                    return new Model\RoleTable($tableGateway);
                },
                Model\RoleTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Role());
                    return new TableGateway('role', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
                Controller\UserController::class => function($container) {
                    return new Controller\UserController(
                            $container->get(Model\UserTable::class)
                    );
                },
                Controller\PersonnelController::class => function($container) {
                    return new Controller\PersonnelController(
                            $container->get(Model\PersonnelTable::class)
                    );
                },
                Controller\RegionController::class => function($container) {
                    return new Controller\RegionController(
                            $container->get(Model\RegionTable::class)
                    );
                },
                Controller\DistrictController::class => function($container) {
                    return new Controller\DistrictController(
                            $container->get(Model\DistrictTable::class)
                    );
                },
                Controller\RoleController::class => function($container) {
                    return new Controller\RoleController(
                            $container->get(Model\RoleTable::class)
                    );
                },
            ],
        ];
    }

}
