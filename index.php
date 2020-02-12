<?php

$start = microtime(true);

require_once 'src/app/BinarySearch.php';
use app\BinarySearch;

$path = 'input.txt';
$key = 'ключ199999999';

$file = new BinarySearch($path, $key);
print $file->search() . PHP_EOL ;

$finish = microtime(true);
$delta = $finish - $start;
print $delta;