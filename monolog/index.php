<?php

require 'vendor/autoload.php';

use Monolog\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\SwiftMailerHandler;
use Monolog\Handler\MongoDBHandler;

use Monolog\Processor\UidProcessor;
use Monolog\Processor\MemoryUsageProcessor;
//use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\WebProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\TagProcessor;
use Monolog\Processor\PsrLogMessageProcessor;

use Monolog\Formatter\HtmlFormatter;

$logger = new Logger('ORDER-CLIENT');

$logger->pushProcessor(new UidProcessor());
$logger->pushProcessor(new MemoryUsageProcessor(true, true));
//$logger->pushProcessor(new MemoryPeakUsageProcessor());
$logger->pushProcessor(new WebProcessor());
$logger->pushProcessor(new ProcessIdProcessor());
$logger->pushProcessor(new IntrospectionProcessor(Logger::INFO));
$logger->pushProcessor(new TagProcessor(['order', 'client']));
$logger->pushProcessor(new PsrLogMessageProcessor());

$logger->pushProcessor(function($record) {
    $record['extra']['uuid'] = time();
    return $record;
});

/////////////////////////// 文件日志
// $logger->pushHandler(
//     new StreamHandler(
//         '/Users/JING/wwwroot/php.dev/jingplus/samples/_log/monolog/a.log',
//         Logger::DEBUG,
//         true,
//         0777
//     )
// );

// $logger->addRecord(Logger::INFO, 'message', ['name' => 'jingwentian']);
// $logger->withName('ORDER-SERVICE')->addRecord(Logger::INFO, 'message', ['name' => 'jingwentian']);

/////////////////////////// 批量设置 Handlers

# email config
$emailOptions = [
    'smtp_host' => 'mail.example.cn',
    'smtp_port' => 25,
    'smtp_user' => 'xxxxxx',
    'smtp_pass' => 'xxxxxxxxxxx',
    'from' => 'xxxxxx',
    'from_name' => '订单服务',
    'subject' => '订单服务报警dev',
    'send_to' => ['tianjingwen@example.com' => '测试邮件服务'],
];
$transport = (new \Swift_SmtpTransport($emailOptions['smtp_host'], $emailOptions['smtp_port']))->setUsername($emailOptions['smtp_user'])->setPassword($emailOptions['smtp_pass']);
$mailer = new \Swift_Mailer($transport);
$message = (new \Swift_Message($emailOptions['subject']))->setFrom([$emailOptions['from'] => $emailOptions['from_name']])->setTo($emailOptions['send_to'])->setContentType('text/html');

$handlers = [
	//new StreamHandler('/Users/JING/wwwroot/php.dev/jingplus/samples/_log/monolog/b.log', Logger::DEBUG, true, 0777),
	new RotatingFileHandler('/Users/JING/wwwroot/php.dev/jingplus/samples/_log/monolog/b.log', 30, Logger::DEBUG, true, 0777),
	(new SwiftMailerHandler($mailer, $message, Logger::INFO))->setFormatter(new HtmlFormatter())
];
$logger->setHandlers($handlers);

// $emailHandler = new SwiftMailerHandler($mailer, $message, Logger::INFO);
// $emailFormatter = new HtmlFormatter();
// $emailHandler->setFormatter($emailFormatter);
// $logger->pushHandler($emailHandler);

$logger->addRecord(Logger::DEBUG, 'title message', ['name' => 'jingwentian', 'age' => 18]);