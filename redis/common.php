<?php 

require 'vendor/autoload.php';

use Predis\Client;

$config = [
    'scheme' => 'tcp',
    'host'=> '127.0.0.1',
    'port' => 6379
];

$redis = new Client($config);

