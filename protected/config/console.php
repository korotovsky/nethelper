<?php

return array(
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name' => 'Network Helper',
    'language' => 'ru',
    'preload'=>array('log'),

    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),

    'modules'=>array(
    ),

    'components'=>array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=nethelper',
            'emulatePrepare' => true,
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
        ),
    ),

    'params'=>array(
        'edns' => '172.23.160.2, 172.23.167.2',
        'wdns' => '172.23.160.2, 172.23.167.2',
        'wdns3' => '8.8.8.8, 8.8.4.4',

        'egateway' => '172.23.160.202', 
        'wgateway' => '172.23.167.2',
        'wgateway3' => '172.23.96.254',

        'config' => '/etc/dhcp3/dhcpd.conf',
        'adminEmail' => 'info@itmages.ru',
    ),
);
