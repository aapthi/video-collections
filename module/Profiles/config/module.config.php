<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Profiles\Controller\Profiles' => 'Profiles\Controller\ProfilesController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'profiles' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/profiles',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Profiles\Controller\Profiles',
                        'action'     => 'index',
                    ),
                ),
            ),  
			'view-profile' => array(
				'type' => 'literal',
				'options' => array(
					'route'    => '/view-profile',
					'defaults' => array(
						'controller' => 'Profiles\Controller\ProfilesController',
						'action'     => 'viewProfile',
					),
				),
			),
			'user' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/user/[:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&+;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Profiles\Controller\Profiles',
						'action'     => 'index',
					),
				),
			),
			'search-result_user' => array(
				'type'    => 'segment',
				'options' => array(
					'route' => '/search-result_user[/:search_name]',
					'constraints' => array(
					  'action' => '[a-zA-Z][a-zA-Z0-9_-|]*',
                      'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-|]*',
					),
					'defaults' => array(
						'controller' => 'Profiles\Controller\Profiles',
						'action'     => 'searchResult',
					),
				),
			),
			'profile-user' => array(
                       'type'    => 'segment',
                       'options' => array(
                           'route' => '/profile-user[/:id]',
                            'constraints' => array(
                               'id' => '[%&;a-zA-Z0-9][%&+,;a-zA-Z0-9_~-]*',
                            ),
                           'defaults' => array(
                               'controller' => 'Profiles\Controller\Profiles',
                               'action'     => 'viewProfileUser',
                    ),
                 ),
             ),
			 'edit-profile' => array(
                       'type'    => 'segment',
                       'options' => array(
                           'route' => '/edit-profile[/:uid]',
                            'constraints' => array(
                               'id' => '[%&;a-zA-Z0-9][%&+,;a-zA-Z0-9_~-]*',
                            ),
                           'defaults' => array(
                               'controller' => 'Profiles\Controller\Profiles',
                               'action'     => 'editProfile',
                    ),
                 ),
             ),
		),
	),     
    'view_manager' => array(
        'template_path_stack' => array(
            'profiles' => __DIR__ . '/../view',
        ),
		'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
	
);
?>