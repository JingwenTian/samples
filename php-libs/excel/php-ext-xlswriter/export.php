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
    $data[] = [
        'name' => 'JingwenTian'.$i,
        'idcard' => '370725199092024857',
        'age' => $i,
        'sex' => $i,
        'order_id' => 'E222222222222'.$i
    ];
}
$header = ['name', 'idcard', 'age', 'sex', 'order_id'];

$filePath = $excel->fileName('demo1.xlsx')->header($header)->data($data)->output();

echo show_time(microtime(true) - $t).PHP_EOL;
echo show_memory(memory_get_peak_usage() - $m).PHP_EOL;

var_dump($filePath);

