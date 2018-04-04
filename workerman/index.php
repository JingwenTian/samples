<?php

require './vendor/autoload.php';

use Workerman\Worker;
use \Workerman\Lib\Timer;

Worker::$daemonize  = true;
Worker::$pidFile    = '/Users/JING/wwwroot/php.dev/eventmosh/demos/_log/workerman/workerman.pid';
Worker::$stdoutFile = '/Users/JING/wwwroot/php.dev/eventmosh/demos/_log/workerman/stdout.log';
Worker::$logFile    = '/Users/JING/wwwroot/php.dev/eventmosh/demos/_log/workerman/process.log';

$worker = new Worker();
$worker->count = 2;
$worker->name = 'workerman-process-name';
$worker->user = 'JING';
$worker->reloadable = true;

$worker->onWorkerStart = function($worker)
{
    $interval = 2;
    Timer::add($interval, function()
    {
        echo date('Y-m-d H:i:s') . '-----' . PHP_EOL;
    });
};

Worker::runAll();
