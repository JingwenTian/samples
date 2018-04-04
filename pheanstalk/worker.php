<?php

date_default_timezone_set('PRC');

require './vendor/autoload.php';

use Workerman\Worker;
use \Workerman\Lib\Timer;

use Pheanstalk\Pheanstalk;
use Pheanstalk\Job as PheanstalkJob;

// workerman global config
Worker::$daemonize  = true;
Worker::$pidFile    = '/home/tianjingwen/webroot/demo/log/workerman/workerman_beanstalkd.pid';
Worker::$stdoutFile = '/home/tianjingwen/webroot/demo/log/workerman/stdout_beanstalkd.log';
Worker::$logFile    = '/home/tianjingwen/webroot/demo/log/workerman/process_beanstalkd.log';


// instance workerman worker
$worker = new Worker();
$worker->count = 20;
$worker->name = 'workerman-process-name';
$worker->user = 'JING';
$worker->reloadable = true;

// instance beanstalkd client
$pheanstalk = new Pheanstalk('127.0.0.1:11300');
$queue = 'order_cancel_delay_queue';

$success = 0;

$worker->onWorkerStart = function($worker) use ($pheanstalk, $queue, $success)
{
	global $success;

	$interval = 0.5;
	Timer::add($interval, function() use ($worker, $pheanstalk, $queue, $success)
    {
		try {
			$job = $pheanstalk->watchOnly($queue)->reserve(0);

			if ($job instanceof PheanstalkJob) {

				global $success;
				$success+=20;

				echo '[' . date('Y-m-d H:i:s') . '][INFO] ';

	            echo '[' . $success . ']' . 'worker id: ' . $worker->id . ', job id: ' . $job->getId() . ', job payload: ' . $job->getData() . PHP_EOL;

	            // $pheanstalk->bury($job);
	            // $pheanstalk->kickJob($job);

	            $pheanstalk->delete($job);
	            
	        }
			
		} catch (\Throwble $e) {
			echo '[' . date('Y-m-d H:i:s') . '][ERROR] ';
			echo $e->getMessage() . PHP_EOL;
		}

    });

};

Worker::runAll();