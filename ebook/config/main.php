<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
	'name'=>'SKYHINT',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'ebook\controllers',
	'modules' => [
		/* 'user' => [
			'class' => 'dektrium\user\Module',
			'controllerMap' => [
				'registration' => 'ebook\controllers\user\RegistrationController',
				'security' => 'ebook\controllers\user\SecurityController',
				'recovery' => 'ebook\controllers\user\RecoveryController'
			],
			'modelMap' => [
				'RegistrationForm' => 'ebook\models\user\RegistrationForm',
				'User' => 'ebook\models\user\User',
				'LoginForm' => 'ebook\models\user\LoginForm',
			],
			// uncomment if in production
			//'enableConfirmation' => true, 
			//'enableUnconfirmedLogin' => false,
			
			'enableConfirmation' => false,
			'enableUnconfirmedLogin' => true,
			'enableFlashMessages' => false,
			
		], */
		
	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
		
		'view' => [
			'theme' => [
				'pathMap' => [
					'@dektrium/user/views' => '@frontend/views/user'
				],
			],
		],
         'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ], 
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
	
	/* 'modules' => [
        'supplier' => [
            'class' => 'ebook\modules\supplier\Module',
        ],
		'catalog' => [
            'class' => 'ebook\modules\catalog\Module',
        ],
		'client' => [
            'class' => 'ebook\modules\client\Module',
        ],
    ], */
	
	
    'params' => $params,
];
