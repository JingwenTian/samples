<?php

date_default_timezone_set('PRC');

require './vendor/autoload.php';

use MongoDB\Client;

$driverOptions = ['typeMap' => ['document' => 'array', 'root' => 'array']];
$options = ['timeout' => 300, 'replicaSet' => 'moshRsM'];
$mongoClient = new Client('mongodb://mosh:ilovechina@127.0.0.1:27018,127.0.0.1:27019/evente', $options, $driverOptions);
$mongo = $mongoClient->selectCollection('evente', 'delay_queue');

// insert
for($i = 0; $i <= 100; $i++)
{
	$data = [
		'topic' 	=> 'order_cancel',
		'payload'	=> json_encode(['increment_id' => 'E' . rand(100000, 999999)]),
		'status'	=> 1,
		'created_at'=> date('Y-m-d H:i:s'),
		'updated_at'=> date('Y-m-d H:i:s'),
		'expired_at'=> date('Y-m-d H:i:s', time() + rand(30, 500))
	];
	$res = $mongo->insertOne($data);
	echo $res->getInsertedCount() . PHP_EOL;

	//sleep(1);
}


// findOneAndUpdate
// $condition = [
// 	'topic' => 'order_cancel', 
// 	'status' => 1,
// 	'expired_at' => ['$lte' => date('Y-m-d H:i:s')] // '$gte'
// ];
// $update = ['$set' => ['status' => 2, 'updated_at' => date('Y-m-d H:i:s')]];
// $options = ['sort' => ['expired_at' => 1]];
// $res = $mongo->findOneAndUpdate($condition, $update, $options);
// print_r($res);




