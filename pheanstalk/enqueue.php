<?php

date_default_timezone_set('PRC');

require 'vendor/autoload.php';

use Pheanstalk\Pheanstalk;

$pheanstalk = new Pheanstalk('127.0.0.1:11300');

// ----------------------------------------
// producer (queues jobs)

for ($i = 0; $i < 1; $i ++) {
	$time = time();
	$delay = mt_rand(10, 20);
	$plyload = ['increment_id' => 'E' . mt_rand(1000000, 99999999), 'created' => date('Y-m-d H:i:s', $time), 'expired' => date('Y-m-d H:i:s', $time + $delay)];

	$jobId = $pheanstalk->useTube('order_cancel_delay_queue')->put(json_encode($plyload), Pheanstalk::DEFAULT_PRIORITY, $delay);
	echo "new job id: {$jobId}\n";
}


