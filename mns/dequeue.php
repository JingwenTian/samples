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


while(true)
{
	$receiptHandle = null;
	try {
	    $res = $queue->receiveMessage(30);
	    echo "ReceiveMessage Succeed! \n";
	    echo $res->getMessageBody() . PHP_EOL;
	    
	    $receiptHandle = $res->getReceiptHandle();

	} catch (MnsException $e) {
	    echo "ReceiveMessage Failed: " . $e->getMessage();
	    continue;
	}

	try {
        $res = $queue->deleteMessage($receiptHandle);
        echo "DeleteMessage Succeed! \n";
    } catch (MnsException $e) {
        echo "DeleteMessage Failed: " . $e->getMessage();
        continue;
    }

}


