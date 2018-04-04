<?php

/**
 * @Author: jingwentian
 * @Date:   2018-03-28 15:17:13
 * @Last Modified by:   jingwentian
 * @Last Modified time: 2018-03-29 09:26:48
 */
require 'common.php';

$conf = new \RdKafka\Conf();	
$conf->set('sasl.mechanisms', 'PLAIN');	
$conf->set('sasl.username', $options['username']);	
$conf->set('sasl.password', $options['password']);	
$conf->set('security.protocol', 'SASL_SSL');	
$conf->set('api.version.request', 'true');	
$conf->set('ssl.ca.location', $options['ssl_ca_path']);	
$conf->set('message.send.max.retries', 5);	
$conf->set('client.id', 'bi-data-report');
$conf->set('group.id', 'PID-evente-financial'/*$options['options']['publish']['producer'] ?? ''*/);
$conf->set('socket.timeout.ms', 50);
$conf->set('socket.blocking.max.ms', 1);

$rk = new RdKafka\Producer($conf);	
$rk->setLogLevel(LOG_DEBUG);	
$rk->addBrokers($options['server']);	
$topic = $rk->newTopic('evente-financial-test'/*$options['options']['publish']['topic'] ?? ''*/);	

echo 'topic name:' . $topic->getName() . PHP_EOL;

for ($i = 0; $i <= 100; $i++) {

	$json = json_encode(['key' => $i, 'date' => date('Y-m-d H:i:s')]);
	$key = md5(time());

	$topic->produce(RD_KAFKA_PARTITION_UA, 0, $json, $key);		
	echo "send succ:" . $key . PHP_EOL;

	sleep(1);
}
