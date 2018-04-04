<?php 

require 'common.php';

while (true) {
   if ($redis->LLEN('queue:order-payment')) {
	$re = $redis->RPOP('queue:order-payment');
        $arr = json_decode($re, true);
        print_r($arr);
  }

}
