<?php

require __DIR__ . '/php_sdk/mns-autoloader.php';

use AliyunMNS\Client;
use AliyunMNS\Requests\SendMessageRequest;
use AliyunMNS\Exception\MnsException;

$accessId = "xxxxx";
$accessKey = "xxxxxx";
$endPoint = "https://20353742.mns.cn-beijing.aliyuncs.com/"; // mns.cn-beijing.aliyuncs.com
$queueName = 'test';

$client = new Client($endPoint, $accessId, $accessKey);
$queue = $client->getQueueRef($queueName);


for($i = 0; $i < 100; $i++)
{	
	$now = date('Y-m-d H:i:s');
	$expire = date('Y-m-d H:i:s', time() + 10);
	$delaySeconds = 10;

	$messageBody = json_encode(['key' => $i, 'type' => 'pay_success', 'date' => $now, 'expire' => $expire]);
	$request = new SendMessageRequest($messageBody, $delaySeconds);

	try {
	    $res = $queue->sendMessage($request);
	    //echo $res . PHP_EOL;
	    echo "MessageSent! \n";
	} catch (MnsException $e) {
	    echo "SendMessage Failed: " . $e->getMessage();
	}
	sleep(3);

}


