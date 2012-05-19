<?php

return array(
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name' => 'Network Helper',
    'language' => 'ru',
    'preload' => array('log'),

    'import' => array(
        'application.models.*',
        'application.components.*',
    ),

    'modules' => array(
    ),

    'components' => array(
        /*
        * Компонент кэширования memcached
        */
        'cache' => array(
            /*'class' => 'system.caching.CDummyCache',*/
            'class' => 'system.caching.CMemCache',
            'useMemcached' => true, # For php5-memcached package 
            'servers' => array(
                array(
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 80
                ),
            ),
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'class' => 'WebUser',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array('guest'),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=nethelper',
            'schemaCachingDuration' => 86400,
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ),
        'session' => array(
            'class' => 'system.web.CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'sessions',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                    'enabled' => false
                ),
            ),
        ),
    ),

    'params' => array(
        'adminEmail' => 'info@itmages.ru',
    ),
);
