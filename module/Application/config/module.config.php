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
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
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
			'cat' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/cat/[:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&+;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'index',
					),
				),
			),
			'play-video' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/play-video[/:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'playVideo',
					),
				),
			),
			'search-result' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/search-result[/:search_name]',
					'constraints' => array(
					  'action' => '[a-zA-Z][a-zA-Z0-9_-|]*',
                      'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-|]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'searchResult',
					),
				),
			),
			'view-profile1' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/view-profile1',
					'constraints' => array(
					  'action' => '[a-zA-Z][a-zA-Z0-9_-|]*',
                      'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-|]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'viewprofile',
					),
				),
			),
			'view' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/view',
					'constraints' => array(
					  'action' => '[a-zA-Z][a-zA-Z0-9_-|]*',
                      'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-|]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'view',
					),
				),
			),
			'view1' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/view1',
					'constraints' => array(
					  'action' => '[a-zA-Z][a-zA-Z0-9_-|]*',
                      'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-|]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'view1',
					),
				),
			),
			'search-title-result' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/search-title-result[/:search_name]',
					'constraints' => array(
					  'action' => '[a-zA-Z][a-zA-Z0-9_-|]*',
                      'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-|]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'searchTitleResult',
					),
				),
			),
			'search-user-name' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/search-user-name[/:search_name]',
					'constraints' => array(
					  'action' => '[a-zA-Z][a-zA-Z0-9_-|]*',
                      'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-|]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'searchUserName',
					),
				),
			),
			'left-side-bar' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/left-side-bar[/:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&+;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'leftSideBar',
					),
				),
			),
			
			'right-side-bar' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/right-side-bar[/:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&+;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Application\Controller\Index',
						'action'     => 'rightSideBar',
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
