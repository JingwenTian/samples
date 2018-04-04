<?php 

require 'vendor/autoload.php';

if (!\extension_loaded('rdkafka') || !\class_exists('RdKafka')) {
    echo "PHP RdKafka extension was not installed\n"; exit;
}

$options = [
	'server'        => 'kafka-ons-internet.aliyun.com:8080',
    'username'      => 'xxxxx',
    'password'      => 'xxxxx',
    'ssl_ca_path'   => __DIR__ . '/ca-cert',
    'options'       => [
        'publish'   => [
        	'order'	=> [
        		'topic'     => 'evente-order-test',
            	'producer'  => 'PID-evente-order'
        	],
            'finance'	=> [
        		'topic'     => 'evente-financial-test',
            	'producer'  => 'PID-evente-financial'
        	],
        	'piaodada'	=> [
        		'topic'     => 'evente-piaodada-test',
            	'producer'  => 'PID-evente-pdd'
        	],
        ],
        'subscribe' => [
            'topic'     => ['evente-order-test', 'evente-financial-test', 'evente-piaodada-test'],
            'consumer'  => 'CID-evente-master-test'
        ],
    ],
];