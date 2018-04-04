<?php

date_default_timezone_set('PRC');

require './vendor/autoload.php';

use MongoDB\Client;
use Workerman\Worker;
use \Workerman\Lib\Timer;

// workerman global config
Worker::$daemonize  = true;
Worker::$pidFile    = '/home/tianjingwen/webroot/demo/log/workerman/workerman_mongo.pid';
Worker::$stdoutFile = '/home/tianjingwen/webroot/demo/log/workerman/stdout_mongo.log';
Worker::$logFile    = '/home/tianjingwen/webroot/demo/log/workerman/process_mongo.log';


// instance workerman worker
$worker = new Worker();
$worker->count = 5;
$worker->name = 'workerman-process-name';
$worker->user = 'JING';
$worker->reloadable = true;

// instance mongodb client
$driverOptions = ['typeMap' => ['document' => 'array', 'root' => 'array']];
$options = ['timeout' => 300, 'replicaSet' => 'moshRsM'];
$mongoClient = new Client('mongodb://mosh:ilovechina@127.0.0.1:27018,127.0.0.1:27019/evente', $options, $driverOptions);
$mongo = $mongoClient->selectCollection('evente', 'delay_queue');


$worker->onWorkerStart = function($worker) use ($mongo)
{
	$interval = 1;
	Timer::add($interval, function() use ($mongo)
    {
        echo '[' . date('Y-m-d H:i:s') . '] ========================' . PHP_EOL;

		$condition = [
			'topic' => 'order_cancel', 
			'status' => 1,
			'expired_at' => ['$lte' => date('Y-m-d H:i:s')] // '$gte'
		];
		$update = ['$set' => ['status' => 2, 'updated_at' => date('Y-m-d H:i:s')]];
		$options = ['sort' => ['expired_at' => 1]];
		$res = $mongo->findOneAndUpdate($condition, $update, $options);
		print_r($res);
    });

};

Worker::runAll();