<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ZfcAdmin\Controller\AdminController' => 'ZfcAdmin\Controller\AdminController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
	   'login' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/login[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'login',
                    ),
                ),
            ),
			
			'dashboard' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/dashboard[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'dashboard',
                    ),
                ),
            ),
			'issues' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/issues[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'issues',
                    ),
                ),
            ),
			'categories-list' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/categories-list[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'categoriesList',
                    ),
                ),
			),	
				'add-category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/add-category[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'addCategory',
                    ),
                ),
			),
			'edit-category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/edit-category[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'editCategory',
                    ),
                ),
			),
			'delete-category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/delete-category[/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZfcAdmin\Controller\AdminController',
                        'action'     => 'deleteCategory',
                    ),
                ),
			),
			
			
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);