<?php
return array(
	'name' => 'demo',
	'id'   =>   "demo-console",
	'basePath' => dirname(__DIR__),
    'controllerNamespace'   =>  "console\controllers",
    'aliases' => [
        '@console' => realpath(__DIR__."/../"),
    ],
    "components" =>  [
        'errorHandler' => [
            'class' => 'console\components\LConsoleErrorHandler',
        ],
    ],
);