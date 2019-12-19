<?php 

require '../common.php';
require 'vendor/autoload.php';

/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet
 * @see https://xlswriter-docs.viest.me/zh-cn/kuai-su-shang-shou/chuang-jian-wen-jian
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$t = microtime(true);
$m = memory_get_peak_usage();

$data = [];
for($i = 0; $i < 200000; $i++) {
    $data[] = ['JingwenTian'.$i, '370725199092024857', $i, $i, 'E222222222222'.$i];
}
$header = ['name', 'idcard', 'age', 'sex', 'order_id'];

$titCol = 'A';
foreach ($header as $key => $value) {
    $sheet->setCellValue($titCol . '1', $value); // 单元格内容写入
    $titCol++;
}
$row = 2; // 从第二行开始
foreach ($data as $item) {
    $dataCol = 'A';
    foreach ($item as $value) {
        $sheet->setCellValue($dataCol . $row, $value); // 单元格内容写入
        $dataCol++;
    }
    $row++;
}

$writer = new Xlsx($spreadsheet);
$writer->save('/home/mosh/tmp/demo2.xlsx');

echo show_time(microtime(true) - $t).PHP_EOL;
echo show_memory(memory_get_peak_usage() - $m).PHP_EOL;

// 55.3609s
// 875.5232925415M