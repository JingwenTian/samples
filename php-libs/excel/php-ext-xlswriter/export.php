<?php 

require '../common.php';

/**
 * @see https://github.com/viest/php-ext-xlswriter
 * @see https://xlswriter-docs.viest.me/zh-cn/kuai-su-shang-shou/chuang-jian-wen-jian
 */
$config = ['path' => '/home/mosh/tmp'];
$excel  = new \Vtiful\Kernel\Excel($config);

$t = microtime(true);
$m = memory_get_peak_usage();

$data = [];
for($i = 0; $i < 100000; $i++) {
    $data[] = ['JingwenTian'.$i, '370725199092024857', $i, $i, 'E222222222222'.$i];
}
$header = ['name', 'idcard', 'age', 'sex', 'order_id'];

$filePath = $excel->fileName('demo1.xlsx')->header($header)->data($data)->output();

echo show_time(microtime(true) - $t).PHP_EOL;
echo show_memory(memory_get_peak_usage() - $m).PHP_EOL;
// 1.2335s
// 48.800155639648M

var_dump($filePath);

