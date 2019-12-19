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
for($i = 0; $i < 200000; $i++) {
    $data[] = ['JingwenTian'.$i, '370725199092024857', $i, $i, 'E222222222222'.$i];
}
$header = ['name', 'idcard', 'age', 'sex', 'order_id'];

$filePath = $excel->fileName('demo1.xlsx')->header($header)->data($data)->output();

echo show_time(microtime(true) - $t).PHP_EOL;
echo show_memory(memory_get_peak_usage() - $m).PHP_EOL;
// 2.4832s
// 97.813583374023M

var_dump($filePath);

