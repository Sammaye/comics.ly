<?php

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
	'timeZone' => 'UTC',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'components' => [
        'log' => [
			'traceLevel' => 3,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
				[
					'class' => 'yii\log\EmailTarget',
					'levels' => ['error'],
					'except' => ['yii\web\HttpException:404'],
					'message' => [
						'from' => [$params['errorEmail'] => 'Cly Errors'],
						'to' => [$params['adminEmail']],
						'subject' => 'c!y Website Error',
					],
				],
				[
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['warning'],
                    'categories' => ['application'],
                    'message' => [
						'from' => [$params['errorEmail'] => 'Cly Errors'],
						'to' => [$params['adminEmail']],
						'subject' => 'c!y Website Warning',
                    ],
                ],
	        ],
        ],
    	'user' => [
			'class' => 'common\components\User',
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
		],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
	        'viewPath' => '@common/mails',
        ],
        'assetManager' => [
	        'bundles' => [
		        'yii\bootstrap\BootstrapAsset' => [
			        'basePath' => '@webroot',
			        'baseUrl' => '@web',
			        'sourcePath' => null,
		        ],
		        'yii\bootstrap\BootstrapPluginAsset' => [
			        'basePath' => '@webroot',
			        'baseUrl' => '@web',
			        'sourcePath' => null,
		        ]
	        ],
        ],
        'authManager' => [
	        'class' => 'common\components\PhpManager',
	        'defaultRoles' => ['guest', 'tier2User'],
	        'ruleFile' => '@common/rbac/rules.php',
	        'itemFile' => '@common/rbac/items.php'
        ],
        'urlManager' => [
	        'enablePrettyUrl' => true,
	        'showScriptName' => false,
	        'cache' => null,
	        'rules' => [
		        '<controller:[\w-]+>/<id:[\d\w]{24,}>'=>'<controller>/view',
		        '<controller:[\w-]+>/<action:[\w-]+>/<id:[\d\w]{24,}>'=>'<controller>/<action>',
		        '<controller:[\w-]+>/<action:[\w-]+>'=>'<controller>/<action>',
		        'comic/<id:[\d\w]{24,}>/<date:.[^/]*>'=>'comic/view',
		        // your rules go here
	        ]
        ],
        'formatter' => ['class' => 'common\components\Formatter'],
        
        # You will need to setup your environments to add these application keys
        'authClientCollection' => [
	        'class' => 'yii\authclient\Collection',
	        'clients' => [
	        	'google' => [
	        		'class' => 'yii\authclient\clients\GoogleOAuth',
	        		'clientId' => '',
	        		'clientSecret' => ''
        		],
        		'facebook' => [
        			'class' => 'yii\authclient\clients\Facebook',
        			'clientId' => '',
        			'clientSecret' => '',
        		],
        	],
        ]
    ],
];