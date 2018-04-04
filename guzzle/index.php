<?php

require 'vendor/autoload.php';

try {
	$success = 0;

	$options = [
        'base_uri'  => 'http://tj.inner.evente.cn:8001',
        'timeout'   => 10,
        'headers'   => ['User-Agent' => 'EA PHP SDK']
    ];
    $params = [
    	'data'	=> 'eyIkZGlzdGluY3RfaWQiOiIzMDgxMzgiLCIkdGltZSI6IjIwMTctMDItMjggMjA6MDA6MDgiLCIkdHlwZSI6InRyYWNrIiwiJHRpbWVfZnJlZSI6ZmFsc2UsIiRwcm9qZWN0IjoiZXZlbnRlMi4wIiwiJHByb3BlcnRpZXMiOnsiJG9yZ19pZCI6MTA0ODMsIiRhZ2VudF9pZCI6IjAiLCIkaXAiOiIxMTcuMTM2LjQxLjU1IiwiJGRldmljZV9pZCI6IjMwODEzOCIsIiRkZXZpY2VfdHlwZSI6MywiJGNoYW5uZWxfaWQiOiJ3ZWl4aW5icmlkZ2UuY29tIiwiJGFwcF92ZXJzaW9uIjoiMi4wIiwiJHVzZXJfYWdlbnQiOiJNb3ppbGxhXC81LjAgKExpbnV4OyBBbmRyb2lkIDUuMTsgbTEgbWV0YWwgQnVpbGRcL0xNWTQ3STsgd3YpIEFwcGxlV2ViS2l0XC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBWZXJzaW9uXC80LjAgQ2hyb21lXC81My4wLjI3ODUuNDkgTW9iaWxlIE1RUUJyb3dzZXJcLzYuMiBUQlNcLzA0MzAyNCBTYWZhcmlcLzUzNy4zNiBNaWNyb01lc3NlbmdlclwvNi41LjQuMTAwMCBOZXRUeXBlXC80RyBMYW5ndWFnZVwvemhfQ04iLCIkcmVmZXJyZXIiOiJodHRwOlwvXC9tcC53ZWl4aW5icmlkZ2UuY29tIiwiJHJlZmVycmVyX2hvc3QiOiJtcC53ZWl4aW5icmlkZ2UuY29tIiwiJGZpcnN0X3JlZmVycmVyIjoiaHR0cDpcL1wvbXAud2VpeGluYnJpZGdlLmNvbSIsIiRmaXJzdF9yZWZlcnJlcl9ob3N0IjoibXAud2VpeGluYnJpZGdlLmNvbSIsIiR1cmwiOiIiLCIkdXJsX3BhdGgiOiIiLCJwcm9kdWN0cyI6eyJwcm9kdWN0X3R5cGUiOiJldmVudCIsInByb2R1Y3RfaWQiOjEwMTEzNCwicHJvZHVjdF9zdWJfaWQiOjU0NDMsInByb2R1Y3RfcmVsX2lkIjo4NjE0LCJwcm9kdWN0X3ByaWNlIjoiMTgwLjAwIiwicHJvZHVjdF9udW1iZXIiOjJ9LCJvcmRlciI6eyJvcmdfaWQiOjEwNDgzLCJvcmRlcl9pZCI6MTM2NzgxMSwiaW5jcmVtZW50X2lkIjoiMjAxNzAyMjgyMDAwMDgxMzg5MDA1OSIsInVzZXJfaWQiOjMwODEzOCwiY291bnRyeV9jb2RlIjoiODYiLCJtb2JpbGUiOiIxNTkxNTg1MzA0NCIsIm9yZGVyX3R5cGUiOiJldmVudCIsIm9yZGVyX21vbmV5IjoiMzYwLjAwIiwiZGlzY291bnRfbW9uZXkiOiIwLjAwIiwiZnJlaWdodF9tb25leSI6MCwicGF5X21vbmV5IjoiMzYwLjAwIiwib3JkZXJfc3RhdGUiOjEwLCJvcmRlcl9kYXRlIjoiMjAxNy0wMi0yOCAyMDow'
    ];

    $client = new GuzzleHttp\Client($options);
    
    for ($j = 1; $j <= 100; $j++)
    {
    	$promises = [];
    	for ($i = 1; $i <= 1000; $i++) 
	    {
	        $promises[] = $client->getAsync('/order/__ea.gif', ['query' => $params]);
	    }
	    $response = GuzzleHttp\Promise\unwrap($promises);
	    //$response = GuzzleHttp\Promise\settle($promises)->wait();

        array_map(function($resp) use (& $success, & $error) {
        	$resp->getReasonPhrase() === 'OK' && $success++;
        }, $response);
       
        echo $j * count($response) . PHP_EOL;
    }

    echo 'done:' . $success;
    
} catch (\Throwable $e) {
    echo $e->getMessage();die;
}


