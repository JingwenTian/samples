<?php

/**
 * @Author: jingwentian
 * @Date:   2018-03-28 15:17:08
 * @Last Modified by:   jingwentian
 * @Last Modified time: 2018-03-29 09:49:48
 */
require 'common.php';

$conf = new \RdKafka\Conf();
$conf->set('sasl.mechanisms', 'PLAIN');
$conf->set('api.version.request', 'true');
$conf->set('sasl.username', $options['username']);
$conf->set('sasl.password', $options['password']);
$conf->set('security.protocol', 'SASL_SSL');
$conf->set('ssl.ca.location', $options['ssl_ca_path']);
$conf->set('message.send.max.retries', 5);
$conf->set('client.id', 'bi-data-report');
$conf->set('group.id', $options['options']['subscribe']['consumer'] ?? '');
$conf->set('metadata.broker.list', $options['server']);
// Topic config
$topicConf = new \RdKafka\TopicConf();
$topicConf->set('auto.offset.reset', 'smallest');
$conf->setDefaultTopicConf($topicConf);
// High-level consumer
$consumer = new \RdKafka\KafkaConsumer($conf);
// Subscribe to topic 'CID-evente-bi-*'
// $topic = $options['options']['subscribe']['topic'] ?? '';
// $consumer->subscribe([$topic]);

$topic = $options['options']['subscribe']['topic'] ?? [];
$consumer->subscribe($topic);

print_r($consumer->getSubscription()); // Returns an array of topic names

echo "Waiting for partition assignment... (make take some time when\n";	
echo "quickly re-joining the group after leaving it.)\n";

while (true) {
   	$message = $consumer->consume(120 * 1000);
	switch ($message->err) {
	    case RD_KAFKA_RESP_ERR_NO_ERROR:
	        echo $message->payload . PHP_EOL;
	        $properties = [
	            'err'           => $message->err,
	            'topic_name'    => $message->topic_name,
	            'partition'     => $message->partition,
	            'key'           => $message->key,
	            'offset'        => $message->offset,
	        ];
	        echo json_encode($properties, true) . PHP_EOL;
	        echo '-----------------------------'. PHP_EOL;
	        break;
	    case RD_KAFKA_RESP_ERR__PARTITION_EOF: // -191
	        echo "No more messages; will wait for more\n";
	        break;
	    case RD_KAFKA_RESP_ERR__TIMED_OUT: // -185
	        echo "Timed out\n";
	        break;
	    default:
	        echo $message->errstr() . PHP_EOL;
	        break;
	} 
}

