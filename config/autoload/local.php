<?php
return array(
    'db' 				=> 	array(
		'dsn' 			=>	'mysql:dbname=video_collections;host=localhost',
        'username' 		=> 	'root',
        'password' 		=> 	'',
    ),
	'slave1' => array(
		'dsn'      		=> 	'mysql:dbname=video_collections;host=localhost',
        'username' 		=> 	'root',
        'password' 		=> 	'',
    ),
	'slave2' 			=> 	array(
		'dsn'      		=> 	'mysql:dbname=video_collections;host=localhost',
        'username' 		=> 	'root',
        'password' 		=> 	'',
    ),
	'slave3' 			=> 	array(
		'dsn'      		=> 	'mysql:dbname=video_collections;host=localhost',
        'username' 		=> 	'root',
        'password' 		=> 	'',
    ),
	'urls' 				=> 	array(
		'baseUrl' 		=> 	'http://localhost/video-collections/trunk',
		'basePath' 		=> 	'http://localhost/video-collections/trunk/public',
		'imagesUrl'		=>	'#',
	),
	'service_manager' 	=> 	array(
        'factories' 	=> 	array(  
        ),
    ),
	'cache' => array(
		'adapter' => array(
			'name'    => 'Filesystem',
			'options' => array(
				'cache_dir' => __DIR__ . '/../../../data/cache',
				'ttl'       => '3600'
			)
		),
		'plugins' => array(
			array(
				'name'    => 'serializer',
				'options' => array()
			),
			'exception_handler' => array(
				'throw_exceptions' => true
			)
		)
	),
);
