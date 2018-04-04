<?php

/*
   put with delay               release with delay
  ----------------> [DELAYED] <------------.
                        |                   |
                        | (time passes)     |
                        |                   |
   put                  v     reserve       |       delete
  -----------------> [READY] ---------> [RESERVED] --------> *poof*
                       ^  ^                |  |
                       |   \  release      |  |
                       |    `-------------'   |
                       |                      |
                       | kick                 |
                       |                      |
                       |       bury           |
                    [BURIED] <---------------'
                       |
                       |  delete
                        `--------> *poof*
 */

date_default_timezone_set('PRC');

require 'vendor/autoload.php';

use Pheanstalk\Pheanstalk;

$pheanstalk = new Pheanstalk('127.0.0.1:11300');

$queue = 'order_cancel_delay_queue';

// ----------------------------------------
// check server availability : true or false
if ($pheanstalk->getConnection()->isServiceListening()) {
	echo "beanstalkd server availability\n";
}

// ----------------------------------------
// Get the size of the queue.

echo 'queue ready state size:' . $pheanstalk->statsTube($queue)->current_jobs_ready . PHP_EOL; // 准备好的消息数量
echo 'queue delayed state size:' . $pheanstalk->statsTube($queue)->current_jobs_delayed . PHP_EOL; // 延时排队的消息数量
echo 'queue reserved state size:' . $pheanstalk->statsTube($queue)->current_jobs_reserved . PHP_EOL; // 取出且未 delete、bury的消息数量
echo 'queue buried state size:' . $pheanstalk->statsTube($queue)->current_jobs_buried . PHP_EOL; // 取出后放入临时仓库的消息数量(可删除、回放到 ready)
