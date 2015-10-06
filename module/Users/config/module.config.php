<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Users\Controller\Users' => 'Users\Controller\UsersController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'users' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/users[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Users\Controller\Users',
                        'action'     => 'index',
                    ),
                ),
            ),  
			'view-profile' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/view-profile',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'viewProfile',
						),
					),
			),	
			'login' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/login',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'login',
						),
					),
			),
			'change-password' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/change-password',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'changePassword',
						),
					),
			),
			//Static Pages
			'about' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/about',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'about',
						),
					),
			),
			'privacy-policy' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/privacy-policy',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'privacyPolicy',
						),
					),
			),
			'terms-conditions' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/terms-conditions',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'termsConditions',
						),
					),
			),
			
			// End 
			
			
			'check-password' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/check-password',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'checkPassword',
						),
					),
			),
			'logout' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/logout',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'logout',
						),
					),
			),
			'forgot-password' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/forgot-password',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'forgotPassword',
						),
					),
			),
			'send-password-reset-url' => array(
					'type' => 'literal',
					'options' => array(
						'route'    => '/send-password-reset-url',
						'defaults' => array(
							'controller' => 'Users\Controller\UsersController',
							'action'     => 'sendPasswordResetUrl',
						),
					),
			),
			'reset-password' => array(
				'type'    => 'segment',
				'options' => array(
					'route'    => '/reset-password[/:id]',
					'constraints' => array(	
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
					),
					'defaults' => array(
						'controller' => 'Users\Controller\UsersController',
						'action'     => 'resetPassword',
					),
				),
			),
			
			'profile' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/profile[/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
					),
					'defaults'    => array(
						'controller'    => 'Users\Controller\Users',
						'action'        => 'profiles',
					),
				),
			),
			'contact-us' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/contact-us[/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
					),
					'defaults'    => array(
						'controller'    => 'Users\Controller\Users',
						'action'        => 'contactUs',
					),
				),
			),
		
			'online-payments' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/online-payments[/:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'onlinePayments',
					),
				),
			),
			'success-payment' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/success-payment[/:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'successPayment',
					),
				),
			),
			'failure-payment' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/failure-payment[/:id]',
					'constraints' => array(
					   'id' => '[%&;a-zA-Z0-9][%&;a-zA-Z0-9_~-]*',
					),
					'defaults' => array(
						'controller' => 'Users\Controller\Users',
						'action'     => 'failurePayment',
					),
				),
			),
			'cron-sent-mails' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/cron-sent-mails[/:id]',
					'constraints' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'     => '[a-zA-Z][a-zA-Z0-9_-]*',
					),
					'defaults'    => array(
						'controller'    => 'Users\Controller\Users',
						'action'        => 'crontosendmails',
					),
				),
			),
		),
	),     
    'view_manager' => array(
        'template_path_stack' => array(
            'users' => __DIR__ . '/../view',
        ),
		'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
	
);
?>