<?php
return array(
	'view_helpers' 				=> 	array(
		'invokables' 			=> 	array(
			'action' 			=> 	'Eva\View\Helper\Action',
		),  
	),
	'router' 					=> 	array(
		'routes' 				=> 	array(
			'home' 				=> 	array(
				// 'type' 			=> 	'Zend\Mvc\Router\Http\Literal',
				'type'    => 'segment',
				'options' 		=> 	array(
					'route' => '/[:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&+;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'index',
					),
				),
			),
			'application' 		=> 	array(
				'type'    		=> 	'Literal',
				'options' 		=> 	array(
					'route'    	=> 	'/application',
					'defaults' 	=> 	array(
						'__NAMESPACE__' 	=> 	'Application\Controller',
						'controller'    	=> 	'Index',
						'action'       		=> 	'index',
					),
				),
				'may_terminate' 	=> 	true,
				'child_routes' 		=> 	array(
					'default' 		=> 	array(
						'type'    	=> 	'Segment',
						'options' 	=> 	array(
							'route'    			=> 	'/[:controller[/:action]]',
							'constraints' 		=> 	array(
								'controller' 	=> 	'[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     	=> 	'[a-zA-Z][a-zA-Z0-9_-]*',
							),
							'defaults' 			=> array(
							),
						),
					),
				),
			),
			'header-categories' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/header-categories[/:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'supplyHeaderCategories',
					),
				),
			),
			'cms' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/cms[/:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&+;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'cms',
					),
				),
			),
			'like-unlike' => array(
				'type' => 'literal',
				'options' => array(
					'route'    => '/like-unlike',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'likeUnlike',
					),
				),
			),
			'share' => array(
				'type' => 'literal',
				'options' => array(
					'route'    => '/share',
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'share',
					),
				),
			),
		),
	),
	'service_manager' 			=> 	array(
		'abstract_factories' 	=> 	array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'aliases' 				=> 	array(
			'translator' 		=> 	'MvcTranslator',
		),
	),
	'translator' => array(
		'locale' => 'en_US',
		'translation_file_patterns' => array(
			array(
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			),  
		),       
	),
	'default' => array(  
	  'type' => 'Segment',   
	  'options' => array(       
		'route' => '/[:controller[/:action][/:locale]]',     
		'constraints' => array(            
		  'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',            
		  'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',           
		  'locale'     => '[a-zA-Z]{2}_[a-zA-Z]{2}',       
		),       
		'defaults' => array(           
		  'locale' => 'en_US'       
		),   
	  ),
	),
	'controllers' 					=> 	array(
		'invokables' 				=> 	array(
			'Application\Controller\Index' 	=> 	'Application\Controller\IndexController'
		),
	),
	'view_manager' 						=> 	array(
		'display_not_found_reason' 		=> 	true,
		'display_exceptions'       		=> 	true,
		'doctype'                  		=> 	'HTML5',
		'not_found_template'       		=> 	'error/404',
		'exception_template'       		=> 	'error/index',
		'template_map' => array(
			'layout/layout'           	=> 	__DIR__ . '/../view/layout/layout.phtml',
			'application/index/index' 	=> 	__DIR__ . '/../view/application/index/index.phtml',
			'error/404'               	=> 	__DIR__ . '/../view/error/404.phtml',
			'error/index'             	=>	__DIR__ . '/../view/error/index.phtml',
		),
		'template_path_stack' 			=> array(
			__DIR__ . '/../view',
		),
		'strategies' 					=> array(
			'ViewJsonStrategy',
		),
	),	
);
