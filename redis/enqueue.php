<?php

require 'common.php';

while(true) {
  $data = json_encode(['time' => date('Y-m-d H:i:s')]);
  echo $redis->LPUSH('queue:order-payment', $data) . PHP_EOL;
  sleep(1);
}
