<?php
return array(
	'name' => "APP",
	'id'   => "php-demo",
	'basePath' => dirname(__DIR__),
	'defaultRoute' => 'site/index',
    'controllerNamespace' => "backend\controllers",
    'aliases' => [
        '@backend' => realpath(__DIR__."/../"),
    ],
    "components" => [
        // 内部组件
        'request' => [
            'class' => 'common\components\LHttpRequest',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'cookieValidationKey' => '22ej6cKTmKmvxLwAgbJeWnm16u1IbLTP',
        ],
        'errorHandler' => [
            'class' => 'common\components\LErrorHandler',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'name' => 'demo-backend',
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-demo', 'httpOnly' => true],
        ],
    ]
);