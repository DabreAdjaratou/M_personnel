<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'login',
                    ],
                ],
            ],
//            'application' => [
//                'type' => Segment::class,
//                'options' => [
//                    'route' => '/application[/:action]',
//                    'defaults' => [
//                        'controller' => Controller\UserController::class,
//                        'action' => 'login',
//                    ],
//                ],
//            ],
            
          'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'login',
                    ],
                ],
            ],
            'user' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/user[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                        'id' => '[0-9]+',
                    ],
                ],
            ],
            
            'personnel' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/personnel[/:action][/:id][/:q]',
                    'defaults' => [
                        'controller' => Controller\PersonnelController::class,
                        'action' => 'index',
                        'id' => '[0-9]+',
                    ],
                ],
            ],
            
            'region' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/region[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\RegionController::class,
                        'action' => 'index',
                        'id' => '[0-9]+',
                    ],
                ],
            ],
            
            'district' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/district[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\DistrictController::class,
                        'action' => 'index',
                        'id' => '[0-9]+',
                    ],
                ],
            ],
            
             'role' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/role[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\RoleController::class,
                        'action' => 'index',
                        'id' => '[0-9]+',
                    ],
                ],
            ],
            
        ],
    ],
    
     
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
           
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
