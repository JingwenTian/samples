<?php

/**
 * https://github.com/laravel/framework/blob/5.6/src/Illuminate/Queue/BeanstalkdQueue.php
 */

date_default_timezone_set('PRC');

require 'vendor/autoload.php';

use Pheanstalk\Pheanstalk;
use Pheanstalk\Job as PheanstalkJob;

$pheanstalk = new Pheanstalk('127.0.0.1:11300');

$queue = 'order_cancel_delay_queue';

// ----------------------------------------
// worker (performs jobs)

while(true) {

	try {
		//$job = $pheanstalk->watch($queue)->ignore('default')->reserve();
		$job = $pheanstalk->watchOnly($queue)->reserve(0);

		echo '[' . date('Y-m-d H:i:s') . '][INFO] ';

		if ($job instanceof PheanstalkJob) {
            echo $job->getId() . '--->' . $job->getData() . PHP_EOL;
            //$pheanstalk->bury($job); // 放入处理中队列(将不被reserve到)
            // ...
            $pheanstalk->delete($job); // 处理完之后消除
        }
		
	} catch (\Throwble $e) {
		echo '[' . date('Y-m-d H:i:s') . '][ERROR] ';
		echo $e->getMessage();
	}
	
}

