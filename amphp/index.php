<?php

//use Amp\Artax\Response;
use Amp\Loop;

use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\Server;
use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Socket;
use Psr\Log\NullLogger;

require __DIR__ . '/vendor/autoload.php';

Loop::run(function () {
    
    // $uris = [
    //     "https://baidu.com/",
    //     "https://weibo.com/",
    //     "https://taobao.com/",
    //     "https://tmall.com/",
    //     "https://github.com/",
    //     "https://sina.com.cn/",
    //     "https://163.com/",
    //     "https://sohu.com/",
    //     "https://aliyun.com/",
    //     "https://t.tt/",
    // ];

    // $client = new Amp\Artax\DefaultClient;
    // $client->setOption(Amp\Artax\Client::OP_DISCARD_BODY, true);

    // try {
    //     foreach ($uris as $uri) {
    //         $promises[$uri] = $client->request($uri);
    //     }

    //     $responses = yield $promises;

    //     foreach ($responses as $uri => $response) {
    //         print $uri . " - " . $response->getStatus() . $response->getReason() . PHP_EOL;
    //     }
    // } catch (Amp\Artax\HttpException $error) {
    //     print $error->getMessage() . PHP_EOL;
    // }


    // Loop::repeat(1000, function () {
    //     print "++ Executing watcher created by Loop::repeat()" . PHP_EOL;
    // });
    // Loop::delay(5000, function () {
    //     print "++ Executing watcher created by Loop::delay()" . PHP_EOL;
    //     Loop::stop();
    //     print "++ Loop will continue the current tick and stop afterwards" . PHP_EOL;
    // });


    // $sockets = [
    //     Socket\listen("0.0.0.0:1337"),
    //     Socket\listen("[::]:1337"),
    // ];
    
    // $server = new Server($sockets, new CallableRequestHandler(function (Request $request) {
    //     return new Response(Status::OK, [
    //         "content-type" => "text/plain; charset=utf-8"
    //     ], "Hello, World!");
    // }), new NullLogger);

    // yield $server->start();

    // Amp\Loop::onSignal(SIGINT, function (string $watcherId) use ($server) {
    //     Amp\Loop::cancel($watcherId);
    //     yield $server->stop();
    // });

    
});

